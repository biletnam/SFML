<?php
class index {
    public
        $arrayText = array();
    function subjectMain() {
        global $db;
            $sub_query=$db->query('SELECT * FROM subject ORDER BY title','��������� ������ � ������� ���������');
            while($subject=$db->fetch_array($sub_query)) {
                $list_sub.='<li class="sub"><a href="subject.php?cat=sub&id='.$subject['id'].'">'.$subject['title'].'</a></li>';
            }
            $this->arrayText=array(
                'title' => '������ ���������',
                'content' => '<tr><ul class="test">'.$list_sub.'</ul></tr>'
                );
    }
    function ListCategory($id) {
        global $db,$sec;
            $id = $sec->ClearInt($id,'�������� ����� �������');
            $subject = $db->query('SELECT title FROM subject WHERE id = "'.$id.'"','������ �������� �� ����������',true);

            $query_cat = $db->query('SELECT id,title FROM subject_category WHERE subject = "'.$id.'"','��������� � �������� �� ����������</br><a href="subject.php?cat=add_cat&sid='.$id.'" style="color: #2D76B9">��������</a>');
            while($cat = $db->fetch_array($query_cat)) {
                $html.='<li class="sub"><a href="subject.php?cat=edit_cat&id='.$cat['id'].'">'.$cat['title'].'</a></li>';
            }
            $this->arrayText = array(
                'title' => '������ ���������',
                'menu' => array(
                        '�������� ���������' => 'subject.php?cat=add_cat&sid='.$id
                    ),
                'content' => '<tr><ul class="test">'.$html.'</ul></tr>'
            );
    }
    function AddCategory($id) {
        global $db,$sec;
        if (isset($id)) {
            $id = $sec->ClearInt($id);
            $sub_query=$db->query('SELECT * FROM subject_category WHERE id='.$id.'','��������� ������ � ������� ���������',true);
            $sid = $sub_query['subject'];
            $title = $sub_query['title'];
            $act = 'edit_cat&id='.$id;
        }
        else {
            $act = 'add_cat';
            $sid = $sec->ClearInt($_GET['sid']);
        }
        $sub_query=$db->query('SELECT * FROM subject ORDER BY title','��������� ������ � ������� ���������');


            while($subject=$db->fetch_array($sub_query)) {
                $list_sub.="<option value='{$subject['id']}'".($subject['id'] == $sid ? ' selected' : '').">{$subject['title']}</option>\n";
            }
        $this->arrayText = array(
                'title' => '������ ���������',
                'content' => '<form action="subject.php?act='.$act.'" method="post"><tr>
         <td width="26%" class="ListTableLeftBar">���������:</td>
         <td width="74%"><input name="title" type="text" style="width: 400px" value="'.$title.'" maxlength="150" />&nbsp;</td>
       </tr>
       <tr>
         <td class="ListTableLeftBar">�������</td>
         <td><select name="subject">
                '.$list_sub.'
             </select></td>
       </tr>
       <tr>
         <td class="ListTableLeftBar">&nbsp;</td>
         <td><input name="ok" type="submit" value="���������" />&nbsp;</td>
       </tr>
       <tr>
         <td class="ListTableLeftBar">&nbsp;</td>
         <td>&nbsp;</td>
       </tr>

</form>'
            );
    }
    function AddCat() {
        global $sec,$err,$db,$mainclass;
        $title=$sec->filter($_POST['title'],150,'�� ������ ������ ���������');
        $subject=$sec->ClearInt($_POST['subject'],'������� �� ������');

        $test_subject=$db->query('SELECT id FROM subject WHERE id="'.$subject.'"','id ����� �������');
        $db->query('INSERT INTO subject_category (`title`,`subject`) VALUES ("'.$title.'","'.$subject.'")');

        return $sec->head('subject.php?cat=sub&id='.$subject.'&m=6');
    }
    function EditCat($id) {
        global $sec,$err,$db,$mainclass;
        $id = $sec->ClearInt($id,'������ id');
        $title=$sec->filter($_POST['title'],150,'�� ������ ������ ���������');
        $subject=$sec->ClearInt($_POST['subject'],'������� �� ������');

        $db->query('SELECT id FROM subject_category WHERE id="'.$id.'"','��������� �� ����������');
        $db->query('SELECT id FROM subject WHERE id="'.$subject.'"','id ����� �������');
        $db->query('UPDATE subject_category SET `title` = "'.$title.'",`subject` = "'.$subject.'" WHERE id = '.$id.'');

        return $sec->head('subject.php?cat=sub&id='.$subject.'&m=1');
    }
}
?>
