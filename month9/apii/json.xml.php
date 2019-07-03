<?php

/**
 *   json  轻量级 javascript对象
 *
 *   {
 *      'name':'zhangsan',
 *      'age':18,
 *      'hobby':'吃'
 *    }
 *
 *  在json外面加引号为json字符串
 *
 * 讲仁义对象转换成json  json_encode 常规的是将数组转换成json字符串
 *
 */

$arr = [
    'name'=>'zhangsan',
    'age'=>18,
    'hobby'=>'吃'
];

$json = json_encode($arr);

$obj = json_decode($json,true);

//var_dump($obj);


/**
 *   xml  可扩展标记语言  自己可以自定义标签
 *
 *      <?xml version='1.0' encoding=''utf-8 ?>
 *      <root>
 *          <name>zhangsan</name>
 *          <age>18</age>
 *          <hobby>吃</hobby>
 *      </root>
 */
//  两种xml解析方式

//  1 、simplexml_load_string  从变量中解析xml  返回对象格式
//  2、 simplexml_load_file   从文件中解析

$str = "<?xml version='1.0' encoding='utf-8' ?>
        <root>
          <name>zhangsan</name>
          <age>18</age>
          <hobby>吃</hobby>
        </root>";

$res =simplexml_load_string($str);
//var_dump(json_decode(json_encode($res),true));

// xmlReader 逐行解析

$xmlReader = new XMLReader();

$xml = $xmlReader->XML($str);

//var_dump($xml);
$data = [];
//解析xml
while ($xmlReader->read()) {
    if ($xmlReader->nodeType == XMLReader::ELEMENT) {
        $nodeName = $xmlReader->name;
    }
    if ($xmlReader->nodeType == \XMLReader::TEXT && !empty($nodeName)) {
        $data[$nodeName] = strtolower($xmlReader->value);
    }
}
//    var_dump($data);

//DOMDocument
$dom = new DOMDocument();
$dom->loadXML($str);

$data = [];

$data['name'] = ($dom->getElementsByTagName('name'))[0]->nodeValue;
$data['age'] = ($dom->getElementsByTagName('age'))[0]->nodeValue;
$data['hobby'] = ($dom->getElementsByTagName('hobby'))[0]->nodeValue;

var_dump($data);