<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Make Model instance
     *
     * @return Model
     * @throws \Exception
     *
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract public function model();

    /**
     * Paginate records for scaffold.
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($perPage, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Model
     */
    public function create(array $input)
    {
        $model = $this->model->newInstance($input);

        $model->save();
        $this->updateRelations($model, $input);

        return $model;
    }

    /**
     * Find model record for given id without fail (exception)
     *
     * @param int $id
     * @param array $columns
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findWithoutFail($id, $columns = ['*'])
    {
        try {
            return $this->find($id, $columns);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Find model record for given id
     *
     * @param int $id
     * @param array $columns
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @param array $input
     * @param int $id
     *
     * @return Builder|Builder[]|Collection|Model
     */
    public function update(array $input, $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        $model->fill($input);

        $model->save();
        $this->updateRelations($model, $input);

        return $model;
    }

    public function updateRelations($model, $attributes)
    {
        foreach ($attributes as $key => $val) {
            if (isset($model) &&
                method_exists($model, $key) &&
                is_a(@$model->$key(), Relation::class)
            ) {
                $methodClass = get_class($model->$key($key));
                switch ($methodClass) {
                    case BelongsToMany::class:
                        $this->saveBelongsToMany($attributes, $key, $model);
                        break;
                    case BelongsTo::class:
                        $this->saveBelongsTo($attributes, $key, $model);
                        break;
                    case HasOneOrMany::class:
                    case HasOne::class:
                        break;
                    case HasMany::class:
                        $this->saveHasMany($attributes, $key, $model);
                        break;
                }
            }
        }

        return $model;
    }

    /**
     * Search the given ID in the array.
     * @param int $id
     * @param array $array
     * @param string $keyName
     *
     * @return bool
     */
    private function findIdExists(int $id, array $array, string $keyName): bool
    {
        foreach ($array as $item) {
            if (isset($item, $item[$keyName]) && (int)$item[$keyName] === $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find the position of the ID in the given array.
     * @param int $id
     * @param array $array
     * @param string $keyName
     *
     * @return int|null
     */
    private function findIndex(int $id, array $array, string $keyName): ?int
    {
        foreach ($array as $index => $item) {
            if (isset($item[$keyName]) && (int)$item[$keyName] === $id) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @param int $id
     *
     * @return bool|mixed|null
     * @throws \Exception
     *
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    /**
     * Save BelongsToMany
     *
     * @param $attributes
     * @param int|string $key
     * @param $model
     *
     * @return void
     */
    private function saveBelongsToMany($attributes, int|string $key, $model): void
    {
        $new_values = array_get($attributes, $key, []);
        $check_values = array_get($attributes, $key, []);
        if (in_array('', $new_values, false)) {
            unset($new_values[array_search('', $new_values, false)]);
        }
        // If there is any value passed
        if (count($check_values)) {
            $first_element = array_shift($check_values);
            // Verify if is array, and if there is, adjust the index to be the id of the relation
            if (is_array($first_element)) {
                $otherKeyTxt = $model->$key()->getOwnerKeyName();
                $otherKeyArray = explode('.', $otherKeyTxt);
                $otherKey = array_pop($otherKeyArray);
                $final_array = [];
                foreach ($new_values as $idx => $item) {
                    $index = $idx;
                    if (isset($item[$otherKey])) {
                        $index = $item[$otherKey];
                        unset($item[$otherKey]);
                    }
                    $final_array[$index] = $item;
                }
                $new_values = $final_array;
            } else {
                $new_values = array_values($new_values);
            }
        }

        $model->$key()->sync($new_values);
    }

    /**
     * Save HasMany
     *
     * @param $attributes
     * @param int|string $key
     * @param $model
     *
     * @return void
     */
    private function saveHasMany($attributes, int|string $key, $model): void
    {
        $new_values = array_get($attributes, $key, []);
        sort($new_values);
        // The name of the class
        $related = get_class($model->$key()->getRelated());

        if (in_array('', $new_values, false)) {
            unset($new_values[array_search('', $new_values, false)]);
        }

        $foreign_key_name = $model->$key()->getForeignKeyName();
        if (str_contains($foreign_key_name, '.')) {
            [$temp, $model_key] = explode('.', $foreign_key_name);
        } else {
            $model_key = $foreign_key_name;
        }



        $model_instance = $this->getModelInstance($related);
        // Get the name of the primary key
        $keyName = $model_instance->getKeyName();
        // Find if the id exists in the itens received
        foreach ($model->$key as $rel) {
            if (!$this->findIdExists($rel->$keyName, $new_values, $keyName)) {
                $rel->delete();
                continue;
            }
            $position = $this->findIndex($rel->$keyName, $new_values, $keyName);
            if (!is_null($position)) {
                $related = get_class($model->$key()->getRelated());
                $related::where($keyName, $rel->$keyName)->update($new_values[$position]);
                unset($new_values[$position]);
                // Sort again the array to the loop for find the item
                sort($new_values);
            }
        }
        // Insert the new ones
        if (count($new_values) > 0) {
            foreach ($new_values as $new_value) {
                $new_value[$model_key] = $model->id;
                $rel = $related::firstOrCreate($new_value);
            }
        }
    }

    /**
     * Save BelongsTo
     *
     * @param array $attributes
     * @param string $key
     * @param $model
     *
     * @return void
     */
    private function saveBelongsTo(array $attributes, string $key, $model): void
    {
        $model_key = $model->$key()->getForeignKeyName();
        $new_value = array_get($attributes, $key, null);
        $new_value = $new_value == '' ? null : $new_value;
        $model->$model_key = $new_value;
    }

    /**
     * @param string $related
     * @return Model
     */
    private function getModelInstance(string $related): Model
    {
        return new $related();
    }

    /**
     * Set the "orderBy" value of the query.
     *
     * @param mixed $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }
}
