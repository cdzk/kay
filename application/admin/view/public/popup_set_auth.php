<div id="setMenuAuth" style="display: none;">
    <div class="box box-solid tree-box">
        <form id="form_setMenuAuth" action="{:url('admin/Role/auth_menu', 'type=save')}" method="post">
            <input type="hidden" name="role_id">
            <input type="hidden" name="checkedAuth">
            <div class="box-body">
                <ul id="menuTree" class="ztree"></ul>
            </div>
            <div class="box-footer">
                <button class="btn btn-default" name="setAuth-btn-cancel" type="button">取消</button>
                <button class="btn btn-info pull-right" type="submit">保存</button>
            </div>
        </form>
    </div>
</div>

<div id="setAuth" style="display: none;">
    <div class="box box-solid tree-box">
        <form id="form_setAuth" action="{:url('admin/Role/auth', 'type=save')}" method="post">
            <input type="hidden" name="role_id">
            <input type="hidden" name="checkedAuth">
            <div class="box-body">
                <ul id="authTree" class="ztree"></ul>
            </div>
            <div class="box-footer">
                <button class="btn btn-default" name="setAuth-btn-cancel" type="button">取消</button>
                <button class="btn btn-info pull-right" type="submit">保存</button>
            </div>
        </form>
    </div>
</div>