{HEADER}
<form action="test.php?sec=add&cat=add" method="post">
    <div class="headi" style="margin: 10px;">���������� �����</div>
    <table width="100%" border="0">
        <tr>
            <td width="26%" class="ListTableLeftBar">���� �����</td>
            <td width="74%"><input name="title" type="text" style="width: 400px" maxlength="150" />&nbsp;</td>
        </tr>
        <tr>
            <td class="ListTableLeftBar">�������</td>
            <td>
                <select name="subject">
                    {ListSubject}
                </select>
            </td>
        </tr>
        <tr>
            <td class="ListTableLeftBar">����� �� ������������?</td>
            <td><input name="status" type="checkbox" value="2" />&nbsp;</td>
        </tr>
        <tr>
            <td class="ListTableLeftBar">&nbsp;</td>
            <td><input name="ok" type="submit" value="���������" />&nbsp;</td>
        </tr>
    </table>
    <p>&nbsp;</p>

</form>
{FOOTER}