<?php
/**
 * @Author: doanlich
 * @Date:   2016-07-27 12:00:27
 * @Last Modified by:   doanlich
 * @Last Modified time: 2016-07-27 15:31:10
 */
if (! function_exists('get_datatable_column')) {
    function get_datatable_column($dataColumns)
    {
        $columns = [];
        foreach ($dataColumns as $key => $column) {
            if(isset($column['selectAll']) && $column['selectAll']) {
                $column['title'] = '<label style="margin-bottom: 0"><input id="datatableSelectAll" type="checkbox" class="minimal-red selected"></label>';
            }
            unset($column['searchType'], $column['searchOption'], $column['defaultOrder'], $column['selectALl']);
            $columns[] = $column;
        }

        return $columns;
    }
}

if (! function_exists('get_datatable_search_column')) {
    function get_datatable_search_column($dataColumns)
    {
        $columns = [];
        foreach ($dataColumns as $key => $column) {
            $columns[$key] = get_search_element($column);
        }

        return $columns;
    }
}

if (! function_exists('get_datatable_default_order')) {
    function get_datatable_default_order($dataColumns)
    {
        $result = '';
        $columns = [];
        foreach ($dataColumns as $key => $column) {
            if(isset($column['defaultOrder']) && $column['defaultOrder'] != null) {
                $columns[] = '['.$key.',\''.$column['defaultOrder'].'\']';
            }
        }
        if(!empty($columns)) {
            $columns = array_reverse($columns);
            $result = '['.implode(',', $columns).']';
        }

        return $result;
    }
}

if (! function_exists('get_search_element')) {
    function get_search_element($column)
    {
        if(!isset($column['searchType']) || $column['searchType'] == null) {
            return '';
        }

        $element = '';

        if($column['searchType'] == 'select') {

            if(!isset($column['searchOption']) || $column['searchOption'] == null) {
                return '';
            }

            $element = '<select class="form-control form-control-filter input-sm"><option></option>';

            foreach ($column['searchOption'] as $key => $value) {
                $element .= '<option value="'.$key.'">'.$value.'</option>';
            }

            $element .= '</select>';
        } else {
            $element = '<input placeholder="'.trans('backend/systems.type_hint').'" class="form-control form-control-filter input-sm" type="'.$column['searchType'].'">';
        }

        return $element;
    }
}
if (! function_exists('convert_url')) {
    function path_to_url($path) {
        return str_replace('\\', '/', $path);
    }
}