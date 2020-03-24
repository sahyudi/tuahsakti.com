</div>


<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="https://tuahsakti.com">Tuah Sakti</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
</div>
<!-- ./wrapper -->

<script type="text/javascript">
    function button_back() {
        window.history.go(-1);
    }

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split(',');
        x1 = x[0];
        x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>
</body>

</html>