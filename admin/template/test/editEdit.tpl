{HEADER}
<div class="headi" style="margin: 10px;">�������������� ����� <a href="test.php?sec=edit&cat=list&id={TestId}">(�����)</a></div>
    <form action="test.php?sec=edit&cat=updateTest&id={TestId}" method="post">
        <table width="100%" border="0">
            <tr>
                <td width="26%" class="ListTableLeftBar">���� �����</td>
                <td width="74%"><input name="title" type="text" style="width: 400px" maxlength="150" value="{InputTitle}" />&nbsp;</td>
            </tr>
            <tr>
                <td class="ListTableLeftBar">�������</td>
                <td>
                    <select name="subject">{ListSubject}
                    </select>
                </td>
            </tr>
            <tr>
                <td class="ListTableLeftBar">����� �� ������������?</td>
                <td><input name="status" type="checkbox" value="2" {Checked} />&nbsp;</td>
            </tr>
            <tr>
                <td class="ListTableLeftBar">&nbsp;</td>
                <td><input name="ok" type="submit" value="��������" />&nbsp;</td>
            </tr>
        </table>
    </form>
{FOOTER}