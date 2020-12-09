$(document).on("submit", "form", function(event) {

    var pt_input = document.getElementById('pt_source'),
        g_input = document.getElementById('g_source');

    console.log(pt_input.files[0], g_input.files[0]);

    let formdata = new FormData(document.getElementById('form'))

    formdata.append( 'pt_source', pt_input.files[0] );
    formdata.append( 'g_source', g_input.files[0] );

    function downloadURI(uri, name)
    {
        var link = document.createElement("a");
        link.setAttribute('download', name);
        link.href = uri;
        document.body.appendChild(link);
        link.click();
        link.remove();
    }

    function loadFile(filePath) {
        let result = null;
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", filePath, false);
        xmlhttp.send();
        if (xmlhttp.status === 200) {
            result = xmlhttp.responseText;
        }
        return result;
    }

    $.ajax({
        type: "POST",
        url: "input.php",
        dataType: "html",
        data: formdata,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(loadFile('file.txt'));
            downloadURI('file.txt', '[Encrypted] ' + loadFile('file.txt') + '.txt');
            swal({
                title: "Succesfully registered!",
                icon: "success",
            }).then(() => {
                location.reload();
            });
        }
    }).done(function(result)
    {
        console.log(result);
    });

    return false;
})