<?php

function json($data,$message,$code){
    return response()->json([
        'data' => $data,
        'message' => $message,
    ],$code);
}
