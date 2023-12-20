
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    @media print {
        body {
            visibility: hidden;
        }
        #printarea {
            visibility: visible;
            position: absolute;
            left: 0;
            top: 0;
            
        }
    }
    #printarea {
        display: flex;
        align-items: center;
        justify-content: center
    }
    #dep {  
        width: 100px;
        height: 100px;   
        float: left; 
        padding-right: 80px;
    } 
    #shs {  
        width: 100px;
        height: 100px;   
        float: right; 
        padding-left: 80px;
    } 
</style>
<body>
    <div class="" id = "printarea">
        <img id = "dep" src="{{ asset('admintemplate/assets/img/deped.png') }}" alt="">
        <center style = "font-family: Tahoma">
            <b> INSPECTION AND ACCEPTANCE REPORT </b> <br>
            Department of Education <br>    
            Region X <br>
            Division of MISAMIS ORIENTAL <br>
            <h3 style = "color: skyblue; font-weight: bold 2px solid;">LUGAIT SENIOR HIGH SCHOOL</h3>
        </center>
        <img id = "shs" src="{{ asset('admintemplate/assets/img/shs-logo.png') }}" alt="">
    </div>
</body>
</html>
<script>
    window.onload = function () {
        window.print();
    }
</script>