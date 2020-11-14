<?php

/*
 * A Simple Code To Search Through Public Channels in Telegram
 *
 * https://github.com/kihanb/TelegramPublicSearch/
 *
*/


function TelegramPublicSearch($channel_id , $query ='', $limit = 5){
    
    $geturl = "https://t.me/s/$channel_id?q=" . urlencode($query);
    $posts = array();
    $founded = 0;
    while(true){
        
        $get = file_get_contents($geturl);
        if(preg_match_all('/<a class="tgme_widget_message_date" href="(.*?)">/', $get, $items)){
            
            foreach($items[1] as $item){
                
                $founded++;
                if($founded <= $limit)
                    $posts[] = $item;
                else
                    break;
                
            }
            
            $geturl = "https://t.me/s/$channel_id?q=" . urlencode($query) . '&before=' . str_replace('https://t.me/'. $channel_id . '/','',$items[1][0]);
            
        }else{
            
            break;
            
        }
        
    }
    return $posts;
}

?>
