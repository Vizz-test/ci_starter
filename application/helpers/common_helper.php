<?php


function preview($data){
    echo '<pre>'; print_r($data); exit;
}


function upload_img($img,$path){
    if ($img["name"] != '') {
        $file_name = $img['name'];
        $size = $img['size'];
        $file_path = $path;
        list($txt, $ext) = explode(".", $file_name);
        $actual_image_name = time() . substr(str_replace(" ", "_", $txt), 5) . "." . $ext;
        $tmp = $img['tmp_name'];
        if (move_uploaded_file($tmp, $file_path . $actual_image_name)) {
            return $actual_image_name;
        } else {
            return false;
        }
    }
}

function upload_csv($csv, $path){
    if ($csv["name"] != '') {
        $file_name = $csv['name'];
        $size = $csv['size'];
        $file_path = $path;
        list($txt, $ext) = explode(".", $file_name);
        $actual_csv_name = time() . substr(str_replace(" ", "_", $txt), 5) . "." . $ext;
        $tmp = $csv['tmp_name'];
        if (move_uploaded_file($tmp, $file_path . $actual_csv_name)) {
            return $actual_csv_name;
        } else {
            return false;
        }
    }
}



function generate_random_key(){
    return mt_rand(1111,9999);
}


function check_existance($table, $where){
    $ci = & get_instance();
    $res = $ci->db->get_where($table, $where);
    if($res->num_rows() > 0){
        return true;
    }else{
        return false;
    }
}

function ajax_response($status, $data, $message){
    $res = [
        'status' => $status,
        'data' => $data,
        'message' => $message
    ];

    echo json_encode($res);
}


function za_send_email($to, $from,$from_name, $subject, $content){
    $ci = & get_instance();
    $ci->load->library('email');
    
    $config = [
        'protocol' => 'smtp',
        'smtp_host' => SMTP_HOST,
        'smtp_port' => SMTP_PORT,
        'smtp_user' => SMTP_USER,
        'smtp_pass' => SMTP_PASS,
        'mailtype' => 'html'
    ];
    $ci->email->initialize($config);
    $ci->email->to($to);
    $ci->email->from($from, $from_name);
    $ci->email->subject($subject);
    $ci->email->message($content);
    $ci->email->reply_to('support@test.io');
    $res = $ci->email->send();
    //var_dump($res);exit;
    return ($res ? true : false);
}


function send_message($data){
    $ci = & get_instance();
    $ci->load->model('user_model');
    $resp = array();
    $campaign_id = $data->campaign_id;
    $image = $data->image;
    $path = base_url()."images/campaign_img/{$image}";
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $img = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
  
    $number = $data->csv;
    $caption = $data->caption;
    $i = 1;
            foreach ($number as $num){
                $num = str_replace(' ','',$num);
                if($i % 10 != 0){
                    if($num && strlen($num) >= 11){
                        if(num_exists($num)){
                            $data = array("phone"=>$num,"body"=>$base64, 'filename' => 'vizzwebsolutions.jpg', 'caption' => $caption);
                            $sms = curl_sms($data);
                            if($sms->sent == true){
                                $message_data = [
                                    'number' => $num,
                                    'campaign_id' => $campaign_id,
                                    'message' => $caption,
                                    'image' => $image,
                                    'message_id' => $sms->id,
                                    'status' => 1,
                                ];
                                $ci->user_model->save_message($message_data);
                                
                            }else{
                                $ci->session->set_flashdata('errors', "Something went wrong!");
                                redirect(base_url('user/campaigns'));
                            }
                        }
                        
                    }
                }else{
                    sleep(60);
                }
                //print_r($sms);
                // if($sms){
                //     $resp[]=array("phone"=>$number,"body"=>$name,"sent"=>$sms->sent,"message_id"=>$sms->id);
                // }else{
                //     $resp[]=array("phone"=>$number,"body"=>$name,"sent"=>0);
                // }

                //$this->admin_model->send_message($sms->id,10);
            }

}

function curl_sms($data=false){ 
        
    // $data = [
    //     'phone' => '923435951953', // Receivers phone
    //     'body' => 'Hello, Andrew!', // Message
    // ];
    //echo "<pre>";print_r($data);exit;
    $ci = & get_instance();
    $ci->load->model('user_model');
    $settings = $ci->user_model->get_settings();
    foreach($settings as $k => $v){
        $set[$v->setting_name] = $v->setting_value;
    }
    // preview($set);
    $json = json_encode($data); // Encode data to JSON
    // URL for request POST /message
    $data['ackNotificationsOn'] = 1;
    $token = $set['chat_api_token'];
    $instanceId = $set['chat_api_instance_id'];
    // $url = 'https://api.chat-api.com/instance'.$instanceId.'/sendFile?token='.$token;
    $url = 'https://api.chat-api.com/instance'.$instanceId.'/sendMessage?token='.$token;
    // Make a POST request
    $options = stream_context_create(['http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            //'ackNotificationsOn' => 1,
            'content' => $json
        ]
    ]);
    // Send a request
    $result = file_get_contents($url, false, $options);
    $result = json_decode($result);
    return $result;
}

function num_exists($number){
    $number = str_replace(' ','',$number);
    $ci = & get_instance();
    $ci->load->model('user_model');
    $settings = $ci->user_model->get_settings();
    foreach($settings as $k => $v){
        $set[$v->setting_name] = $v->setting_value;
    }
    
  if(strlen($number) >= 11){
    $token = $set['chat_api_token'];
    $instanceId = $set['chat_api_instance_id'];
    $path =  'https://api.chat-api.com/instance'.$instanceId.'/checkPhone?token='.$token.'&phone='.$number;
    $result = file_get_contents($path);
    $result = json_decode($result);
    if($result && !isset($result->error)){
        if($result->result == 'exists'){
            return true;
        }else{
            return false;
        }
    }else{
        $ci->session->set_flashdata('errors', "Please check API, It's not authenticated properly");
        // redirect(base_url('user/campaigns'));
    }
  }
}


