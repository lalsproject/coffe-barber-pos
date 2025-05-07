</div>

<!-- ================== GLOBAL VENDOR SCRIPTS ==================-->
<script src="{{ asset('admin/assets/vendor/modernizr/modernizr.custom.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('admin/assets/vendor/js-storage/js.storage.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/js-cookie/src/js.cookie.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/pace/pace.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/metismenu/dist/metisMenu.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/switchery-npm/index.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') }}">
</script>
<!-- ================== PAGE LEVEL VENDOR SCRIPTS ==================-->
<script src="{{ asset('admin/assets/vendor/countup.js/dist/countUp.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/jvectormap-next/jquery-jvectormap.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/jvectormap-next/jquery-jvectormap-world-mill.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/chartist/dist/chartist.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/flot.curvedlines/curvedLines.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/select2/select2.min.js') }}"></script>
<!-- ================== GLOBAL APP SCRIPTS ==================-->
<script src="{{ asset('admin/assets/js/global/app.js') }}"></script>

<script src="{{ asset('admin/assets/js/components/select2-init.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/datatables-init.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/bootstrap-datepicker-init.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/sweetalert2.js') }}"></script>
<script src="{{ asset('admin/assets/vendor/ckeditor/ckeditor.js') }}"></script>

<!-- ================== PAGE LEVEL APP SCRIPTS ==================-->
<script src="{{ asset('admin/assets/js/components/bootstrap-date-range-picker-init.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/tpicker.js') }}"></script>
<!-- ================== PAGE LEVEL SCRIPTS ==================-->
<script src="{{ asset('admin/assets/js/cards/sessions-by-location.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/countUp-init.js') }}"></script>
<script src="{{ asset('admin/assets/js/cards/total-visits-chart.js') }}"></script>
<script src="{{ asset('admin/assets/js/cards/total-unique-visits-chart.js') }}"></script>
<script src="{{ asset('admin/assets/js/cards/bar-chart-line-three.js') }}"></script>
<script src="{{ asset('admin/assets/js/cards/traffic-sources.js') }}"></script>
<script src="{{ asset('admin/assets/js/customFunction.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js"></script>
@stack('script')
<script>
    $(document).ready(function() {
        $('.start_date').datepicker({
            format: 'yyyy-mm-dd',
            orientation: "bottom auto",
            autoclose: true
        });

        $('.end_date').datepicker({
            format: 'yyyy-mm-dd',
            orientation: "bottom auto",
            autoclose: true
        });
    });
</script>
</body>

</html>
