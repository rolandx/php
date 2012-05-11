<div id='resources'>
        <div id="current-category">
                <?php
                        $upid =$_GET['c'];
                        $views_name = 'zifenlei';
                        $display_id = 'block_2';
                        $view_args = $upid;
                        print views_embed_view($views_name, $display_id,$view_args);
                 ?>
        </div>

        <div id="sub-category">
                <?php
                        $upid =$_GET['c'];
                        $subid =$_GET['sc'];
                        $keys =$_GET['keys'];
                        $views_name = 'zifenlei';
                        $display_id = 'block_1';
                        $view_args = $upid;
                        print views_embed_view($views_name, $display_id,$view_args);
                ?>
        </div>

        <div id="filetype">
        <div class=label>文件格式：</div>
         <ul>
              <li><a href='?c=<?php print $upid ?>&sc=<?php print $subid ?>&filetype=text/plain&keys=<?php print $keys ?>'>文本</a></li>
              <li><a href='?c=<?php  print $upid ?>&sc=<?php print $subid ?>&filetype=audio/mpeg&keys=<?php print $keys ?>'>MP3</a></li>
              <li><a href='?c=<?php  print $upid ?>&sc=<?php print $subid ?>&filetype=application/rar&keys=<?php print $keys ?>'>RAR</a></li>
              <li><a href='?c=<?php  print $upid ?>&sc=<?php print $subid ?>&filetype=application/pdf&keys=<?php print $keys ?>'>PDF</a></li>
         </ul>
        </div>

         <div id="resources-list">
              <?php
                         if(empty($upid))
                         $upid='all';
                         $filetype = $_GET['filetype'];
                         $views_name = 'ziyuanjianjie2';
                         $display_id = 'page_1';
                         $view_args1 = $upid;
                                if(!empty($subid))
                                   $view_args1=$subid;
                         $view_args2 = $filetype;
                         // $view_args3 = $title       ;
                         print views_embed_view($views_name, $display_id,$view_args1,$view_args2);
                ?>
         </div>
</div> <!-- /reesouse -->

-- INSERT --                                                                                                              114,1         66%