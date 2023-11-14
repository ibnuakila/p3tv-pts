<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    function simple ( $request, $table, $primaryKey, $columns )
    {       
    	$ci =& get_instance();

        $bindings = array();
        
        // Build the SQL query string from the request
        $limit = limit( $request, $columns );
        $order = order( $request, $columns );
        $where = filter( $request, $columns, $bindings );

        // Main query to actually get the data
        $sQuery = "
            SELECT * 
            FROM $table 
            $where 
            $limit
        ";
        $data = $ci->db->query($sQuery); 


        // Data set length after filtering
        $rResultTotal =  $ci->db->query("select count(*) as jml from $table")->row(); 
        $recordsTotal = $rResultTotal->jml;

        // Total data set length
        if ( $where != '' )
        {
            
            $tQuery = "
                SELECT $primaryKey
                FROM $table 
                $where
            ";
            $rResultFilterTotal = $ci->db->query($tQuery);
            $iFilteredTotal = $rResultFilterTotal->num_rows();   
            
            $recordsFiltered = $iFilteredTotal;
            
        }else{
            $recordsFiltered = $recordsTotal;
        }

        /*
         * Output
         */
        $output = array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $recordsTotal ),
            "recordsFiltered" => intval( $recordsFiltered ),
            "data"            => data_output( $columns, $data->result_array() )
        );


        return $output;

    } 

    function multiple ( $request, $table, $primaryKey, $columns )
    {       
        $ci =& get_instance();

        $bindings = array();
        //$table = " SELECT id,nmpti,email,IF(status='0','non aktif','aktif') status,file_path FROM user_pengusul JOIN pti ON user_pengusul.kdpti=pti.kdpti ";
        // Build the SQL query string from the request
        $limit = limit( $request, $columns );
        $order = order( $request, $columns );
        $where = filter( $request, $columns, $bindings );

        // Main query to actually get the data
        /*
        $sQuery = "
            SELECT * 
            FROM $table 
            $where 
            $limit
        $data = $ci->db->query($sQuery); 
        ";*/
        $sQuery = $table;
        $sQuery .= $where;
        $sQuery .= $limit;
        $data = $ci->db->query($sQuery); 
        $countt = $ci->db->query($table); 


        // Data set length after filtering
        //$rResultTotal =  $ci->db->query("select count(*) as jml from $table")->row(); 
        //$recordsTotal = $rResultTotal->jml;
        //$rResultTotal =  $data->num_rows(); 
        $recordsTotal = $countt->num_rows();

        // Total data set length
        if ( $where != '' )
        {
            /*
            $tQuery = "
                SELECT $primaryKey
                FROM $table 
                $where
            ";*/
            $tQuery = $table;
            $tQuery .= $where;

            $rResultFilterTotal = $ci->db->query($tQuery);
            $iFilteredTotal = $rResultFilterTotal->num_rows();   
            
            $recordsFiltered = $iFilteredTotal;
            
        }else{
            $recordsFiltered = $recordsTotal;
        }

        /*
         * Output
         */
        $output = array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $recordsTotal ),
            "recordsFiltered" => intval( $recordsFiltered ),
            "data"            => data_output( $columns, $data->result_array() )
        );


        return $output;

    } 

    function criteria ( $request, $table, $primaryKey, $columns, $criteria=null )
    {       
        $ci =& get_instance();

        $bindings = array();
        
        // Build the SQL query string from the request
        $limit = limit( $request, $columns );
        $order = order( $request, $columns );
        $where = filter( $request, $columns, $bindings );

        $criteria = ( $criteria );
        $criteriaSql ='';        
        if ( $criteria ) {
            $where = $where ?
                $where .' AND '.$criteria :
                ' WHERE '.$criteria;

            $criteriaSql = ' WHERE '.$criteria;
        }
        
        // Main query to actually get the data
        $sQuery = "
            SELECT * 
            FROM $table 
            $where 
            $limit
        ";
        $data = $ci->db->query($sQuery); 


        // Data set length after filtering
        $rResultTotal =  $ci->db->query("select count(*) as jml from $table".$criteriaSql)->row(); 
        $recordsTotal = $rResultTotal->jml;

        // Total data set length
        if ( $where != '' )
        {
            $tQuery = "
                SELECT $primaryKey
                FROM $table 
                $where
            ";
            $rResultFilterTotal = $ci->db->query($tQuery);
            $iFilteredTotal = $rResultFilterTotal->num_rows();   
            
            $recordsFiltered = $iFilteredTotal;
            
        }else{
            $recordsFiltered = $recordsTotal;
        }

        /*
         * Output
         */
        $output = array(
            "draw"            => intval( $request['draw'] ),
            "recordsTotal"    => intval( $recordsTotal ),
            "recordsFiltered" => intval( $recordsFiltered ),
            "data"            => data_output( $columns, $data->result_array() )
        );


        return $output;

    } 


    function limit ( $request, $columns )
    {
        $limit = '';

        if ( isset($request['start']) && $request['length'] != -1 ) {
            //$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
            $limit = "LIMIT ".intval( $request['length'] )." OFFSET ".intval( $request['start'] ); 
        }

        return $limit;
    }

    function order ( $request, $columns )
    {
        $order = '';

        if ( isset($request['order']) && count($request['order']) ) {
            $orderBy = array();
            $dtColumns = pluck( $columns, 'dt' );

            for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];

                if ( $requestColumn['orderable'] == 'true' ) {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';

                    $orderBy[] = '`'.$column['db'].'` '.$dir;
                }
            }

            $order = 'ORDER BY '.implode(', ', $orderBy);
        }

        return $order;
    }

    function filter ( $request, $columns, &$bindings )
    {
    	$ci =& get_instance();
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = pluck( $columns, 'dt' );

        if ( isset($request['search']) && $request['search']['value'] != '' ) {
            $str = $request['search']['value'];

            for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search( $requestColumn['data'], $dtColumns );
                $column = $columns[ $columnIdx ];

                if ( $requestColumn['searchable'] == 'true' ) {
                    //$binding = bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                    //$globalSearch[] = "`".$column['db']."` LIKE ".$binding;
                    $globalSearch[] = $column['db']." LIKE '%".$ci->db->escape_like_str($str)."%' ";
                }
            }
        }

        // Individual column filtering
        for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
            $requestColumn = $request['columns'][$i];
            $columnIdx = array_search( $requestColumn['data'], $dtColumns );
            $column = $columns[ $columnIdx ];

            $str = $requestColumn['search']['value'];

            if ( $requestColumn['searchable'] == 'true' && $str != '' ) {
                //$binding = bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
                //$columnSearch[] = "`".$column['db']."` LIKE ".$binding;
                $columnSearch[] = $column['db']." LIKE '%".$ci->db->escape_like_str($str)."%' ";
            }
        }

        // Combine the filters into a single string
        $where = '';

        if ( count( $globalSearch ) ) {
            $where = '('.implode(' OR ', $globalSearch).')';
        }

        if ( count( $columnSearch ) ) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where .' AND '. implode(' AND ', $columnSearch);
        }

        if ( $where !== '' ) {
            $where = ' WHERE '.$where;
        }

        return $where;
    }      

    function data_output ( $columns, $data )
    {
        $out = array();

        for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
            $row = array();

            for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
                $column = $columns[$j];

                // Is there a formatter?
                if ( isset( $column['formatter'] ) ) {
                    $row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
                }
                else {
                    $row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
                }
            }

            $out[] = $row;
        }

        return $out;
    }


    function fatal ( $msg )
    {
        echo json_encode( array( 
            "error" => $msg
        ) );

        exit(0);
    }

    function bind ( &$a, $val, $type )
    {
        $key = ':binding_'.count( $a );

        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );

        return $key;
    }

    function pluck ( $a, $prop )
    {
        $out = array();

        for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
            $out[] = $a[$i][$prop];
        }

        return $out;
    }

    function _flatten ( $a, $join = ' AND ' )
    {
        if ( ! $a ) {
            return '';
        }
        else if ( $a && is_array($a) ) {
            return implode( $join, $a );
        }
        return $a;
    }

?>