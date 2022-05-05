<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

if(!function_exists('buildSql')) {
    function buildSql(Request $request)
    {
        $selectSql = createSelectSql($request);
        $fromSql = " FROM ATHLETES ";
        $whereSql = whereSql($request);
        $groupBySql = groupBySql($request);
        $orderBySql = orderBySql($request);
        $limitSql = createLimitSql($request);

        $SQL = $selectSql . $fromSql . $whereSql . $groupBySql . $orderBySql . $limitSql;
        return $SQL;
    }
}

if(!function_exists('groupBySql')) {
    function groupBySql(Request $request)
    {

        $rowGroupCols = $request->input('rowGroupCols');
        $groupKeys = $request->input('groupKeys');

        if (isDoingGrouping($rowGroupCols, $groupKeys)) {
            $colsToGroupBy = [];

            $rowGroupCol = $rowGroupCols[sizeof($groupKeys)];
            array_push($colsToGroupBy, $rowGroupCol['field']);

            return " GROUP BY " . join(", ", $colsToGroupBy);
        } else {
            // select all columns
            return "";
        }
    }
}

if(!function_exists('isDoingGrouping')) {
    function isDoingGrouping($rowGroupCols, $groupKeys)
        {
            // we are not doing grouping if at the lowest level. we are at the lowest level
            // if we are grouping by more columns than we have keys for (that means the user
            // has not expanded a lowest level group, OR we are not grouping at all).

            return sizeof($rowGroupCols) > sizeof($groupKeys);
        }
}

if(!function_exists('orderBySql')) {
    function orderBySql(Request $request)
    {
        $sortModel = $request->input('sortModel');

        if ($sortModel) {
            $sortParts = [];

            foreach ($sortModel as $key => $value) {
                array_push($sortParts, $value['colId'] . " " . $value['sort']);
            }

            if (sizeof($sortParts) > 0) {
                return " ORDER BY " . join(", ", $sortParts);
            } else {
                return '';
            }
        }
    }
}

if(!function_exists('whereSql')) {
    function whereSql(Request $request)
    {
        $rowGroupCols = $request->input('rowGroupCols');
        $groupKeys = $request->input('groupKeys');
        $filterModel = $request->input('filterModel');

        $whereParts = [];

        if (sizeof($groupKeys) > 0) {
            foreach ($groupKeys as $key => $value) {
                $colName = $rowGroupCols[$key]['field'];
                array_push($whereParts, "{$colName} = '{$value}'");
            }
        }

        if ($filterModel) {
            foreach ($filterModel as $key => $value) {
                if ($value['filterType'] == 'set') {
                    array_push($whereParts, $key . ' IN ("'  . join('", "', $value['values']) . '")');
                }
            }
        }
    }
}

if(!function_exists('createSelectSql')) {
    function createSelectSql(Request $request)
    {
        $rowGroupCols = $request->input('rowGroupCols');
        $valueCols = $request->input('valueCols');
        $groupKeys = $request->input('groupKeys');

        if (isDoingGrouping($rowGroupCols, $groupKeys)) {
            $colsToSelect = [];

            $rowGroupCol = $rowGroupCols[sizeof($groupKeys)];
            array_push($colsToSelect, $rowGroupCol['field']);

            foreach ($valueCols as $key => $value) {
                array_push($colsToSelect, $value['aggFunc'] . '(' . $value['field'] . ') as ' . $value['field']);
            }

            return "SELECT " . join(", ", $colsToSelect);
        }
        return "SELECT * ";
    }
}

// if(!function_exists('buildSql')) {
//   function buildSql(Request $request)
//   {
//       $selectSql = createSelectSql($request);
//       $fromSql = " FROM ATHLETES ";
//       $whereSql = whereSql($request);
//       $groupBySql = groupBySql($request);
//       $orderBySql = orderBySql($request);
//       $limitSql = createLimitSql($request);

//       $SQL = $selectSql . $fromSql . $whereSql . $groupBySql . $orderBySql . $limitSql;
//       return $SQL;
//   }
// }