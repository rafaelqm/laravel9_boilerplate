<?php
/**
 * Helpers.php
 * User: rafael
 * Date: 27/10/17
 * Time: 01:33
 */

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('is_money')) {
    /**
     * Validate money in US and other patterns without the prefix or sufix.
     * Only validates numbers with commas and dots.
     * Ex: 100,00  // is valid
     * Ex: 100.00  // is valid
     * Ex: 100a00  // is invalid
     * Ex: 1,000.0 // is valid
     * Ex: 1.000,0 // is valid
     * @param string $number
     *
     * @return bool
     */
    function is_money($number)
    {
        return preg_match("/^[0-9]{1,3}(,?[0-9]{3})*(\.[0-9]{1,2})?$/", $number) ||
            preg_match("/^[0-9]{1,3}(\.?[0-9]{3})*(,[0-9]{1,2})?$/", $number);
    }

}

if (!function_exists('money_to_float')) {
    /**
     * Transforms a valid money string to float
     *
     * @param string $number
     *
     * @return float
     */
    function money_to_float($number)
    {
        if (preg_match("/^(-)?[0-9]{1,3}(,?[0-9]{3})*(\.[0-9]{1,2})?$/", $number)) {
            return (float)str_replace(',', '', $number);
        } elseif (preg_match("/^(-)?[0-9]{1,3}(\.?[0-9]{3})*(,[0-9]{1,2})?$/", $number)) {
            return (float)str_replace(',', '.', str_replace('.', '', $number));
        } elseif (is_null($number)) {
            return (float)0;
        } else {
            throw new InvalidArgumentException(
                'The parameter is not a valid money string. Ex.: 100.00, 100,00, 1.000,00, 1,000.00'
            );
        }
    }
}

if (!function_exists('float_to_money')) {
    /**
     * Transforms a float to a currency formatted string
     *
     * @param float $number
     *
     * @return string
     */
    function float_to_money($number, $prefix = 'R$ ')
    {
        return $prefix . number_format($number, 2, ',', '.');
    }
}

Collection::macro('dd', function () {
    dd($this);
});

EloquentCollection::macro('dd', function () {
    dd($this);
});

if (!function_exists('get_percentual_column')) {
    /**
     * Recebe o código do insumo e devolve o nome da coluna que contem a porcentagem
     * que gerou este insumo
     *
     * @return string
     */
    function get_percentual_column($codigo_insumo)
    {
        $insumos = [
            '34007' => 'porcentagem_material',
            '30019' => 'porcentagem_faturamento_direto',
            '37367' => 'porcentagem_locacao',
        ];

        return Arr::get($insumos, $codigo_insumo);
    }
}

if (!function_exists('to_fixed')) {
    /**
     * Equivalent to the toFixed method of Javascript Numbers
     * @param float $number
     * @param int $decimals = 2
     *
     * @return string
     */
    function to_fixed($number, $decimals = 2, $decimal_separator = '.')
    {
        return number_format((float)$number, $decimals, $decimal_separator, '');
    }
}

if (!function_exists('to_percentage')) {
    /**
     * Percentage format
     *
     * @return string
     */
    function to_percentage($number)
    {
        return to_fixed($number, 2, ',') . '%';
    }
}

if (!function_exists('mask')) {
    /**
     * Mask
     * echo mask($cnpj, '##.###.###/####-##');
     * echo mask($cpf,  '###.###.###-##');
     * echo mask($cep,  '#####-###');
     * echo mask($data, '##/##/####');
     * echo mask($data, '##/##/####');
     * echo mask($data, '[##][##][####]');
     * echo mask($data, '(##)(##)(####)');
     * echo mask($hora, 'Agora são ## horas ## minutos e ## segundos');
     * echo mask($hora, '##:##:##');
     *
     * @param string $val
     * @param string $mask
     *
     * @return string
     */
    function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }
}


if (!function_exists('datatables_format_date')) {
    function datatables_format_date($column, $text = 'Sem data')
    {
        return function ($model) use ($column, $text) {
            if (empty($model->{$column})) {
                return $text;
            }

            if ($model->{$column} instanceof Carbon) {
                return $model->{$column}->format('d/m/Y');
            }

            return with(new Carbon($model->{$column}))->format('d/m/Y');
        };
    }
}

if (!function_exists('datatables_float_to_money')) {
    function datatables_float_to_money($column, $text = '0,00')
    {
        return function ($model) use ($column, $text) {
            if (empty($model->{$column})) {
                return $text;
            }

            return float_to_money($model->{$column});
        };
    }
}

if (!function_exists('datatables_empty_column')) {
    function datatables_empty_column($column, $msg = 'Sem dados')
    {
        return function ($model) use ($msg, $column) {
            return $model->{$column} ?: $msg;
        };
    }
}
if (!function_exists('clear_fileupload_name')) {
    function clear_fileupload_name(\Illuminate\Http\UploadedFile $file)
    {
        $baseFileName = strtolower($file->getClientOriginalName());
        $ext = strtolower($file->getClientOriginalExtension());
        $filenameWithoutExt = preg_replace("~\." . $ext . "$~i", '', $baseFileName);

        $final = str_slug($filenameWithoutExt) . '.' . $ext;

        return $final;
    }
}

if (!function_exists('unique_fileupload_name')) {
    /**
     * unique_fileupload_name Retorna um nome único, removendo espaços, acentos e adicionando a data no final do arquivo
     * @param $file \Illuminate\Http\UploadedFile
     * @return string
     */
    function unique_fileupload_name(\Illuminate\Http\UploadedFile $file)
    {
        $baseFileName = strtolower($file->getClientOriginalName());
        $ext = strtolower($file->getClientOriginalExtension());
        $filenameWithoutExt = preg_replace("~\." . $ext . "$~i", '', $baseFileName);

        $final = str_slug($filenameWithoutExt) . '_' . date('YmdHis') . '.' . $ext;

        return $final;
    }
}

if (!function_exists('file_storage_url')) {
    /**
     * file_storage_url Retorna o caminho completo com URL do arquivo
     * @param $file string pasta e nome do arquivo
     * @return string Url completo do arquivo
     */
    function file_storage_url($file)
    {
        return Storage::disk(config('filesystems.default'))->url($file);
    }
}

if (!function_exists('file_storage_delete')) {
    /**
     * file_storage_delete Retorna o caminho completo com URL do arquivo
     * @param $file string pasta e nome do arquivo
     * @return boolean True (deleted) or False
     */
    function file_storage_delete($file)
    {
        return Storage::disk(config('filesystems.default'))->delete($file);
    }
}

if (!function_exists('file_storage_upload')) {
    /**
     * file_storage_upload Salva o arquivo no Filesystem configurado
     * @param $path string pasta
     * @param $file file
     * @param $name string nome do arquivo
     * @return string|false
     */
    function file_storage_upload($path, $file, $name)
    {
        return Storage::disk(config('filesystems.default'))->putFileAs($path, $file, $name, 'public');
    }
}


if (!function_exists('file_storage_move')) {
    /**
     * file_storage_move Salva o arquivo no Filesystem destino vindo do local
     * @param $local string Caminho local do arquivo
     * @param $destination pasta e nome do arquivo destino.
     * @return true|false
     */
    function file_storage_move($local, $destination)
    {
        if (!Storage::disk('local')->exists($local)) {
            return false;
        }
        $arquivo = Storage::disk('local')->getDriver()->readStream($local);
        return Storage::disk(config('filesystems.default'))->getDriver()->putStream($destination, $arquivo);

    }
}

if (!function_exists('visualYesNo')) {
    /**
     * visualYesNo
     * @param $var
     * @return green check or red times
     */
    function visualYesNo($var)
    {
        if ($var) {
            return '<i class="fa fa-check text-success"></i>';
        }
        return '<i class="fa fa-times text-danger"></i>';
    }
}

if (!function_exists('uploadValid')) {
    /**
     * uploadValid
     * @param Request $request
     * @param $fileField
     * @param $folder
     * @param $name
     *
     * @return null
     */
    function uploadValid(Request $request, $fileField, $folder, $name)
    {
        if ($request->hasFile($fileField) && $request->file($fileField)->isValid()) {
            $newName = Str::slug($name) . '_' . date('Ymd_his') . '.' . $request->file($fileField)->extension();

            return file_storage_upload('public/' . $folder, $request->file($fileField), $newName);
        }
        return null;
    }
}

if (!function_exists('uploadValidWithoutRequest')) {
    /**
     * uploadValid
     * @param $fileField
     * @param $folder
     * @param $name
     *
     * @return null
     */
    function uploadValidWithoutRequest($fileField, $folder, $name)
    {
        if ($fileField) {
            $newName = Str::slug($name) . '_' . date('Ymd_his') . '.' . $fileField->extension();

            return file_storage_upload('public/' . $folder, $fileField, $newName);
        }
        return null;
    }
}

if (!function_exists('uploadMultiple')) {
    /**
     * uploadMultiple
     * @param Request $request
     * @param $fileField
     * @param $folder
     * @param $name
     *
     * @return null
     */
    function uploadMultiple(Request $request, $fileField, $folder, $name)
    {
        $images = [];
        if ($request->hasFile($fileField)) {
            $image_count = 0;
            foreach ($request->file($fileField) as $image) {
                $image_count++;
                $newName = Str::slug($name) . '_' . $image_count . '_' .
                    date('Ymd_his') . '.' . $image->extension();
                $images[] = file_storage_upload('public/' . $folder, $image, $newName);
            }
        }
        return $images;
    }
}

if (!function_exists('validateCPF')) {
    /**
     * uploadMultiple
     * @param Request $request
     * @param $cpf
     *
     * @return boolean
     */
    function validateCPF($cpf)
    {

        $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);

        // Valida tamanho
        if (strlen($cpf) != 11) {
            return false;
        }

        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) {
            $soma += $cpf[$i] * $j;
        }
        $resto = $soma % 11;

        if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }
        // Calcula e confere segundo dígito verificador

        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) {
            $soma += $cpf[$i] * $j;
        }
        $resto = $soma % 11;

        return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
    }
}

if (!function_exists('validStartEnd')) {

    /**
     * validStartEnd
     *
     * @param string $start_date_scheduled '2020-10-10 10:00:00'
     * @param string $end_date_scheduled '2020-10-10 11:00:00'
     *
     * @return bool
     */
    function validStartEnd(string $start_date_scheduled, string $end_date_scheduled)
    {
        if (strtotime($start_date_scheduled) > strtotime($end_date_scheduled)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('dateBRtoUS')) {
    /**
     * dateBRtoUS
     * Trata navegadores q não possuem suporte ao field DATE, e como foi utilizado o Momment para testar
     * e trocado pelo jQuery Date Picker, a data vem em PT-BR, ou seja DD/MM/YYYY
     * @param $data_recebida
     * @return string YYYY-MM-DD
     */
    function dateBRtoUS($data_recebida)
    {
        if (strpos($data_recebida, '/')) {
            $format = 'Y-m-d';
            $format_from = 'd/m/Y';
            if (strlen($data_recebida) > 10) {
                $format = 'Y-m-d H:i';
                $format_from = 'd/m/Y H:i';
            }
            $data_recebida = Carbon::createFromFormat($format_from, $data_recebida)->format($format);
        }
        if ($data_recebida == '') {
            return null;
        }
        return $data_recebida;
    }
}


if (!function_exists('removeMaskCPF')) {
    function removeMaskCPF($cpf)
    {
        if ($cpf) {

            $cpf_without_mask = str_replace('.', '', $cpf);
            $cpf_without_mask = str_replace('/', '', $cpf_without_mask);
            $cpf_without_mask = str_replace('-', '', $cpf_without_mask);

            return $cpf_without_mask;
        }

        return '';
    }
}

if (!function_exists('array_only')) {
    function array_only($array, $keys): array
    {
        $results = [];

        $placeholder = new stdClass;

        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            $value = data_get($array, $key, $placeholder);

            if ($value !== $placeholder) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }
}
if (!function_exists('array_except')) {
    function array_except(array $array, array|string $keys): array
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = $array;

        Arr::forget($results, $keys);

        return $results;
    }
}
