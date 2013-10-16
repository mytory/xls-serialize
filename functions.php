<?php
/**
 * 엑셀을 읽어들여 배열을 만든 뒤 리턴.
 * 엑셀의 지정된 줄을 key값으로 한 배열들을 묶어서 배열로 만들어 준다.
 * @param string $input_file_name 경로를 포함한 엑셀 파일
 * @param number $sheet_index 몇 번째 시트를 긁을 건지
 * @param number $key_row_index 몇 번째 행을 제목행으로 사용할 것인지
 */
function get_arr_from_xls ($input_file_name, $sheet_index = 0, $key_row_index = 1) {

    if (!isset($objPHPExcel)) {
        include_once 'PHPExcel/Classes/PHPExcel.php';
    }

    $objPHPExcel = PHPExcel_IOFactory::load($input_file_name);
    $objPHPExcel->setActiveSheetIndex($sheet_index);

    $objWorksheet = $objPHPExcel->getActiveSheet();

    $index = 0;
    $data_for_DBs = array ();
    foreach ($objWorksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);

        $row_index = $row->getRowIndex();

        // 배열의 key로 사용할 제목행 앞의 행은 무시한다.
        if ($row_index < $key_row_index) {
            continue;
        }

        // $key_row_index에 설정된 줄의 값을 불러와서 배열의 key로 사용한다.
        if ($row_index == $key_row_index) {
            $column_title_arr = array ();
            foreach ($cellIterator as $cell) {
                $column_index = $cell->getColumn();
                $column_title_arr[$column_index] = str_replace("\n", '', trim($cell->getCalculatedValue()));
            }
            continue;
        }

        foreach ($cellIterator as $cell) {
            $column_index = $cell->getColumn();
            $column_title = $column_title_arr[$column_index];
            if ($column_title == '') {
                continue;
            }

            $data_for_DBs[$row_index][$column_title] = $cell->getCalculatedValue();
        }
    }

    // 메모리 초과로 자꾸 죽는다.
    $objPHPExcel = NULL;

    // 엑셀 하단에 빈 행들이 들어가는 경우가 있다. 그거 해제.
    foreach ($data_for_DBs as $key => $data) {
        $empty_arr = TRUE;
        foreach ($data as $value) {
            if (!empty($value)) {
                $empty_arr = FALSE;
            }
        }
        if ($empty_arr) {
            unset($data_for_DBs[$key]);
        }
    }

    return $data_for_DBs;
}