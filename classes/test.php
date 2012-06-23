<?php
if(!defined('CMS'))die('���� ������');
require './classes/type.extend.php';
    $test_mode=!$sec->Settings();
class test extends Type {
    public $js=array(),
            $id,
            $title='',
            $author='',
            $arr,
            $arr_quest;
    /*
     * � ��� ������������������:
     * �������� �� ������������� �����(����� �� ����������� ���� � �������)
     * ������� �� ���� ���� ��������, ������� ��������� � ����� �����
     * �������� javascript ������ � ��������� � ��������
     * ����� ������� ����� ������� Template_type�
     */
    function Go() {
        global $db,$err,$sec,$other;
        // ������� ��������
        $count_scale=0;
        $id=$sec->ClearInt($_GET['id'],'�������� id ����� �� �����');
        $this->getTest($id);
        $this->id=$id;
        $quest_and_ans=$db->query('SELECT q.id,q.ask,a.title,a.id AS aid, a.correct,q.type,q.code FROM question AS q INNER JOIN answers AS a ON q.id = a.question WHERE test='.$id.' AND q.delete = 1 AND a.delete = 1 ORDER BY q.id ',
        '�� ����� ����, �� �������� � ���� ��� �� �������� :(');
        $this->arr['count_pass']=$other->time->rulesTime($this->arr['count_pass'],array('���','����','���'));
        
        $i='';
        while($w=$db->fetch_array($quest_and_ans)) {
            // ��������� � ������ �����
            if ($i==$w['id']) {
                switch ($type) {
                    case '1':
                        $this->arr_quest['answers'][]=$this->typeOneYet($w);
                        break;
                    case '2':
                        exit('��������� ������. ������� ������ ��� ������ ����!');
                        break;
                    default:
                        break;
                }
            }else {
                // ������ ���������, �������� �� � ��������� � ���������� �������
                $i=$w['id'];
                $type=$w['type'];
                // ��� ���������� ����� ���������. ���������� ���������� ������ �� ����.
                if(!empty($this->arr_quest)) {
                    $this->js['questions'][]=$this->arr_quest;
                    unset($this->arr_quest);
                }
                switch ($type) {
                    case '1':
                        $this->arr_quest=$this->typeOne($w);
                        break;
                    case '2':
                        $this->arr_quest=$this->typeTwo($w);
                        break;
                    default:
                        continue;
                        break;
                }
            $this->arr['count']++;    
            }
        }
        //shuffle($this->arr['answers']);
        $this->js['questions'][]=$this->arr_quest;
        
        /* ������� ����� �� ������, ����� �� ����� ������������ �������� */
        shuffle($this->js['questions']);
        array_splice($this->js['questions'],20);
    }
    function generateJSTest($array) {
        return '<script type="text/javascript">var test_id = '.$this->id.' ,arr ='.json_encode($array).'</script>';
    }
    function charseTrue($str,$first='cp1251',$second='utf-8') {
        $str=iconv($first, $second, $str);
        if(!$str) {
            return 'error';
        }
        return $str;
    }
    // ������ ������ ���������� ����� �����
    function Scale($count) {
        if ($count > 20) 
            $count = 20;
        
        for ($id=1; $id <= $count; $id++) {
            $sc.=$this->For_li($id);
        }
        return $sc;
    }
 
/* 
 * ������� ���������� �� ������� ����� � ��������, � �������� �� �����������
 */
    function getTest($id) {
        global $db,$err;
        
        $this->arr=$db->query('SELECT n.title, n.user, n.count_pass, s.title AS sub_title FROM nametest AS n INNER JOIN subject AS s ON n.subject=s.id WHERE n.id='.$id.' AND n.status="2" AND n.delete!=2',
        '���� �� ������',true);
        $this->title=$this->arr['title'];
        
        $author=$db->query('SELECT name,surname FROM user WHERE id="'.$this->arr['user'].'" LIMIT 1');
        if ($db->num_rows($author) == 0) {
            $this->author='�� �������';
        }
        else {
            $author=$db->fetch_array($author);
            $this->author=$author['surname'].' '.$author['name'];
        }
    }

    function SecBust($id) {
        $salt='this_test_have_'.$id.'_idsfml';
        $_SESSION['sec']=md5($salt);
        $_SESSION['asks']=array();
    }
    function For_li($id) {
        return '<button class="btn btn-small" id="'.$id.'">&nbsp;&nbsp;&nbsp;</button>';
    }
}
$t=new test;
?>