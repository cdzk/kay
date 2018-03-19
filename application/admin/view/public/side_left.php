<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li role="presentation" {$Request.controller=='Index' ? 'class="active"' : ''}><a href="{:url('admin/Index/index')}"><i class="fa fa-home"></i> 管理首页</a></li>
            {$sys_menu}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>