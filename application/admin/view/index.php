<!-- Main content -->
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">System Information</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered no-margin">
                            <tbody>
                            <tr>
                                <td width="120">Software Name：</td>
                                <td>{$Think.config.system.soft_name}</td>
                            </tr>

                            <tr>
                                <td>Software Version：</td>
                                <td>{$Think.config.system.version}</td>
                            </tr>

                            <tr>
                                <td>Core Version：</td>
                                <td>{$Think.THINK_VERSION}</td>
                            </tr>

                            <tr>
                                <td>Developer Team：</td>
                                <td><a href="http://www.siyi360.com" target="_blank">思议创想</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

<!-- requireJs 2.3.5 -->
<script src="{$Think.config.path.static}js/require.js"></script>
<script>
    require(['{$Think.config.path.static}js/require.config.js'], function () {
        require(
            [
                'jquery',
                'bootstrap',
                'slimscroll',
                'adminLTE',
                'admin',
            ],
            function ($) {
                $(function () {
                    admin.setMainHeight();
                    // 根据窗口大小调整 main区域的高度
                    $(window).resize(function() {
                        admin.setMainHeight();
                    });

                    // 左侧菜单滚动条
                    var $h = $(window).height()-($('.main-footer').height()+parseInt($('.content-wrapper').css('paddingTop'))+30);
                    $(".sidebar-menu").slimScroll({
                        height: $h+'px'
                    });
                });
            }
        );
    });
</script>