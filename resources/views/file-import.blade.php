<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Import Export Excel & CSV to Database in Laravel 7</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
alpha/css/bootstrap.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css"
href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<body>

    <div class="container mt-5 text-center">

        <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                <div class="custom-file text-left">
                    <input type="file" name="file"  id="customFile" required>

                </div>
            </div>
            <button class="btn btn-info">Import data</button>
            <a class="btn btn-success" href="{{ route('file-export') }}">Export data</a>
            <button type="button" class="btn btn-primary" id="upload" value="Upload" onclick="UploadProcess()" >Read Data</button>
        </form>
        <br>
        <div id="ExcelTable"></div>
    </div>

</body>
</html>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script type="text/javascript">
    function UploadProcess() {
        //Reference the FileUpload element.
        var fileUpload = document.getElementById("customFile");
        //Validate whether File is valid Excel file.
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx|.csv)$/;
        if (regex.test(fileUpload.value.toLowerCase())) {
            if (typeof (FileReader) != "undefined") {
                var reader = new FileReader();

                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                        GetTableFromExcel(e.target.result);
                    };
                    reader.readAsBinaryString(fileUpload.files[0]);
                } else {
                    //For IE Browser.
                    reader.onload = function (e) {
                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        GetTableFromExcel(data);

                    };
                    reader.readAsArrayBuffer(fileUpload.files[0]);
                }
            } else {
                alert("This browser does not support HTML5.");
            }
        } else {
            alert("Please upload a valid format file.");
        }
    };
    function GetTableFromExcel(data) {
        //Read the Excel File data in binary

        var workbook = XLSX.read(data, {
            type: 'binary'
        });

        //get the name of First Sheet.
        var Sheet = workbook.SheetNames[0];
        //Read all rows from First Sheet into an JSON array.
        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[Sheet]);
        //Create a HTML Table element.
        var myTable  = document.createElement("table");
        myTable.border = "1";

        //Add the header row.
        var row = myTable.insertRow(-1);

        //Add the header cells.
        var headerCell = document.createElement("TH");
        headerCell.innerHTML = "Id";
        row.appendChild(headerCell);

        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Name";
        row.appendChild(headerCell);

        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Country";
        row.appendChild(headerCell);

        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Age";
        row.appendChild(headerCell);

        headerCell = document.createElement("TH");
        headerCell.innerHTML = "Date";
        row.appendChild(headerCell);

         headerCell = document.createElement("TH");
        headerCell.innerHTML = "Gender";
        row.appendChild(headerCell);


        //Add the data rows from Excel file.

            //Add the data row.
            var row = myTable.insertRow(-1);

            //Add the data cells.
            var cell = row.insertCell(-1);
            cell.innerHTML = excelRows[0].Id;

            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[0].Name;

            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[0].Country;

            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[0].Age;

            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[0].Date;

            cell = row.insertCell(-1);
            cell.innerHTML = excelRows[0].Gender;



        var ExcelTable = document.getElementById("ExcelTable");
        ExcelTable.innerHTML = "";
        ExcelTable.appendChild(myTable);
    };
</script>
<script>
    @if(Session::has('message'))
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true
}
        toastr.success("{{ session('message') }}");
@endif

@if(Session::has('error'))
toastr.options =
{
    "closeButton" : true,
    "progressBar" : true
}
        toastr.error("{{ session('error') }}");
@endif
</script>



