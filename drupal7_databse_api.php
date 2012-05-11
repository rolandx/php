<?php 
//站位符
//This is code: 
db_query("SELECT * FROM {node} WHERE nid IN (:nids)",array(':nids'=> array(13,42,144)));

db_query("SELECT * FROM {node} WHERE nid IN (:nids_1, :nids_2, :nids_3)",array(
           ':nids_1'=> 13,
           ':nids_2'=> 42,
           '"nids_3'=> 144,                   
         ));
db_query("SELECT * FROM {node} WHERE nid IN (13,42,144)");
