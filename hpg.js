// Javascript for switching icon
function switchIcon(element){
    var source = element.src;
    var pieces = element.id.split("-");
    var famId = pieces[0];
    var visitId = pieces[1];
    var value = 0;

    if(source.indexOf("qm3") > 0){
        value = 1;
    } else if(source.indexOf("cm3") > 0){
        value = 2;
    } else {
        value = 0;
    }

    // Make ajax request
    var http = false;

    if(navigator.appName == "Microsoft Internet Explorer") {
      http = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
      http = new XMLHttpRequest();
    }

    http.abort();
    http.open("GET", "updateDB.php?famId=" + famId + "&visitId=" + visitId + "&value=" + value, true);
    http.onreadystatechange=function() {
        if(http.readyState == 4) {
            if(value == 1){
                element.src = "cm3.jpg";
            } else if(value == 2){
                element.src = "d3.jpg";
            } else {
                element.src = "qm3.jpg";
            }
        }
    }
    http.send(null);
}
