<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>jQuery Add / Remove Table Rows</title>
    <style>
        table{
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table, th, td{
            border: 1px solid #cdcdcd;
        }
        table th, table td{
            padding: 5px;
            text-align: left;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".add-row").click(function(){
                var name = $("#name").val();
                var email = $("#email").val();
                var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + email + "</td></tr>";
                $("table tbody").append(markup);
            });

            // Find and remove selected table rows
            $(".delete-row").click(function(){
                $("table tbody").find('input[name="record"]').each(function(){
                    if($(this).is(":checked")){
                        $(this).parents("tr").remove();
                    }
                });
            });
        });

        function addLangFrom() {

            var ihtml = "";

            ihtml =  "<tr>"
                + "<td class='text-center'>4</td>"
                + "<td>"
                + "<div class='mt-2'>"
                + "<select data-placeholder='Select your favorite actors' class='tom-select w-full'>"
                + "<option value=''>언어선택</option>"
                + "<option value='kr'>한국어</option>"
                + "<option value='en'>영어</option>"
                + "<option value='jp'>일본어</option>"
                + "<option value='ch'>중국어</option>"
                + "</select>"
                + "</div>"
                + "</td>"
                + "<td><button class='btn btn-outline-pending w-24 inline-block'>취소</button></td>"
                + "</tr>";
            console.log(ihtml);
            //document.getElementById('langTable').append(ihtml);
            //$("table tbody").append(ihtml);
            $('#langTable').append(ihtml);
        }

    </script>
</head>
<body>
<form>
    <input type="text" id="name" placeholder="Name">
    <input type="text" id="email" placeholder="Email Address">
    <input type="button" class="add-row" value="Add Row">
</form>
<table>
    <thead>
    <tr>
        <th>Select</th>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><input type="checkbox" name="record"></td>
        <td>Peter Parker</td>
        <td>peterparker@mail.com</td>
    </tr>
    </tbody>
</table>
<button type="button" class="delete-row">Delete Row</button>
</body>
</html>
