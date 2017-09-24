<html>
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
    </script>
    <script>
        $(document).ready(function($){
            $('#getupdate').click(function() {
                var symbol = $('input[id=symb]').val();
                var url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20WHERE%20symbol%3D"+symbol+"&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";

                $.getJSON(url, function(data) {
                    var items = [];
                    $.each(data.query.results.quote, function(key, val) {
                        items.push('<li id="' + key + '">' + val + '</li>');

                    });
                    $('<ul/>', { 'class': 'my-new-list', html: items.join('')}).appendTo('body');
                });
            });
        });
    </script>

</head>
<body>
<div style="padding:16px;">
    Stock Ticker : <input id="symb" type="textbox" value="Ticker">
</div>
<button id="getupdate" name = "getupdate" type="button">Get Updates!</button>
</body>
</html>