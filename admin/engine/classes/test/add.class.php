<?php
/**
 * Description of test
 *
 * @author �������
 */
require(PATH.'engine/classes/other/other.class.php');
class add extends someFunction {
    function testAdd() {
        global $sec,$db,$mainclass;
        
        $title=$sec->filter($_POST['title'],150,'�� ������ ������ ���������');
        $subject=$sec->ClearInt($_POST['subject'],'������� �� ��������');
        $status=((int)$_POST['status']==2) ? '2' : '1';

        $test_subject=$db->query('SELECT id FROM subject WHERE id="'.$subject.'"','id ����� �������');
        $db->query('INSERT INTO nametest (`title`,`subject`,`status`,`user`) VALUES ("'.$title.'","'.$subject.'","'.$status.'","'.$mainclass->user['id'].'")');

        $sec->head('test.php?sec=add&cat=question&id='.mysql_insert_id().'&m=6');
    }

    function testMain() {
        global $db,$sec,$tmp;
            $tmp->setVar('title','���������� �����');
            $sub_query=$db->query('SELECT * FROM subject ORDER BY title','��������� ������ � ������� ���������');
            $sid = $sec->ClearInt($_GET['sid']);

            while($subject=$db->fetch_array($sub_query)) {
                $list_sub.='
                    <option value="'.$subject['id'].'"'.($subject['id'] == $sid ? ' selected' : '').'>'.$subject['title'].'</option>'."\n";
            }
            $tmp->setVar('ListSubject',$list_sub);
            
        
    }

    function testQuestion($id=false,$message=false,$number_quest=2,$array=false) {
        global $db,$err,$sec,$m,$tmp;
        
        $tmp->setVar('title','���������� ��������');
        $tmp->setJS(array('addanswers','jquery.filedrop','fileupload','file'));
        $tmp->setVar('return','');
        $tmp->setVar('checkedAnswer','');
        
        $id=$sec->ClearInt($_GET['id'],'������ id');
        /* ������� ���������, ���� ��� ����� */
        if($message) {
            $_GET['m'] = $message;
            
        }
        /* �������� �� ������������� ����� */
        $arr=$db->query('SELECT id,title FROM nametest WHERE `id`='.$id.' AND `delete` != "2" LIMIT 1','������ ����� �� �������',true);
        $i=20;
        if (strlen($arr['title']) > $i) {
            $arr['title']=substr($arr['title'], 0, $i).'...';
        }
        if(isset($_GET['ret'])) {
            $tmp->setVar('return','(�����)');
            $arr['link']='&ret=from_edit';
        }
        /* ������� ���������� �������������� */
        $arr['uid'] = uniqid();

        if($array) {
            $a=1;
            $tmp->setVar('checkedAnswer','checked');
            $tmp->setVar('return','(�����)');

            foreach($array as $k=>$v) {
                $arr_td.=$this->Tr($v['input'], $v['check'], $a);
                $a++;
            }
            $arr['link']='&ret=from_edit';
        } else {
            $arr_td.=$this->Tr('',false,1);
            $arr_td.=$this->Tr('',false,2);
        }
        $tmp->setVar('testId',$arr['id']);
        $tmp->setVar('testTitle',$arr['title']);
        $tmp->setVar('testUnique',$arr['uid']);
        $tmp->setVar('countAnswer',$number_quest);
        $tmp->setVar('answers',$arr_td);
    }
    /* ����������� �������
     * ��������� ���������� 1 � 2 ���� �������
     * ���� ������� ������ ��� 1, �� 1 ���.
    */
    public function testAddQuestion() {
        global $err,$sec,$db,$mainclass;
        $type = 1;
        $id = $sec->ClearInt($_GET['id'],'�������� ����� �������');
        /* �������� �� ������������� ����� */        
        $query = $db->query('SELECT title FROM nametest WHERE `id`='.$id.' AND `delete` != "2" LIMIT 1','������ ����� �� �������');

        /* �������� ��������� */
        $title = $sec->filter($_POST['title'],false,'�� �������� �� ������ ������ ��������?');
        
        /* �������� �������� ���������� ������� */
        $array_answers = $this->RealCountAnswers(8,false,1);
        
        if (count($array_answers) == 1) {
            $type = 2;
        }
        else {
            if (count($array_answers) > 8) {
                return $err->GNC('����� ����� ����� ����� ��������');
            }
            /* ���������, ���� �� � ������� ���������� ����� */
            if (!$this->isIssetTrueAnswer($array_answers)) {
                return $err->GNC('�� �� ������� ���������� �����');
            }
            
        }
        
        $db->query('INSERT INTO question (ask,type,test,ball) VALUES ("'.$title.'",'.$type.','.$id.',0)');
        $last_id = mysql_insert_id();

        foreach($array_answers as $k => $v) {
            $db->query('INSERT INTO answers (title,question,correct,ball) VALUES ("'.$v['input'].'",'.$last_id.','.($type == 2 ? '1' : $v['check']).',1)');
        }
        
        $link=$this->pasteLink();
        $file=$this->addFile();
        
        if ($_POST['answers_next'] == '2' && $type == 1) {
            $mainclass->tmpName = 'addQuestion';
            return $this->TestQuestion($id,5,count($array_answers),$array_answers);
        }
            
        else
            return $sec->head('test.php?sec=add&cat=question&id='.$id.'&m=5&ret');
    }
    function Tr($input='',$check=false,$i) {
        return '<div class="answer" id="input'.$i.'"><input type="checkbox" name="ok'.$i.'" '.($check=='2' ? 'checked' : '').' value="2" class="big_checkbox" /><input name="answer'.$i.'" type="text" value="'.stripslashes($input).'" class="big_input" style="width: 400px" /></div>';
    }
    
}
?>
