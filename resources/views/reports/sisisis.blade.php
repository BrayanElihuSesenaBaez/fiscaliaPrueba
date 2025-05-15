<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Delito</title>
    <!-- Estilos CSS para el PDF -->
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .section {

            font-family: var(--bs-body-font-family);
            font-size: var(--bs-body-font-size);
            color: #212529;
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: inherit;

        }
        .table-no-border td {
            border: none;
        }
        header {
            padding: 10px;
            margin-bottom: 125px;
        }
        .header:after{
            content: "";
            display: table;
            clear: both;
        }
        .logo{
            text-align: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        #logo img{
            width: 180px;
            height: 90px;
        }
        .infHeader{
            left: 150px;
            text-align: center;
            margin-top: -60px;
        }
        .infHeader h1{
            font-family: "Gibson";
            display:inline-block;
            font-size: 1.15em;/*tamaño de la letra*/
            font-weight: bold;
            color: #4A001F;
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2;
            text-transform: uppercase;
            text-align: center;
            padding: 5px 0; /* Espacio entre el texto y las líneas */

        }
        .infHeader div {
            font-size: 0.9em;
            color: #343a40;
            line-height: 1.2;
            margin-top: 2px
        }
        #project{
            color: #212529;
            display: inline-block;
            text-align: left;
            width: 70%;
            font-size: 1em;
            margin-top: 30px;
        }
        #project2{
            color:#212529;
            display: inline-block;
            text-align: left;
            width: 60%;
            font-size: 1em;
            margin-top: 20px;
        }
        #project span, #project2 span {
            font-weight: bold;
            color: #333;
        }

        #project div, #project2 div {
            margin-bottom: 5px;
        }
        .table-right{
            float: right;
            margin: 10px 0;
            padding: 10px;
            width: 300px;
            height: 10px;
        }
        .table-right th,
        .table-right td {
            border: 1px solid #000; /* Bordes de las celdas */
            padding: 7px;
            text-align: left;
        }

        .table-right th {
            background-color: #f2f2f2; /* Color de fondo de los encabezados */
        }
        .act{
            text-align: center;
        }
        .parrafo{
            border: 1px solid #000;
            text-align: left;
            width: auto;
            height: auto;
        }
        .parrafo p{
            text-align: left;
        }

        #company {
        position: absolute;
        top: 80px; /* Ajusta la distancia desde arriba */
        right: 20px; /* Ajusta la distancia desde la derecha */
        /*background: lightblue; /* Solo para ver el contenedor claramente */
        padding: 10px;
        }
        .sect1{
            border: 1px solid black;
        }
        .sect{
            border: 1px solid black;
        }
        .sect1, td{
            text-align: center;
        }
        #sect2, h3, p{
            text-align: center;
        }
        .sect3{

        }
        .sect3, h2{
            text-align: center;
        }
        .sect4{
            border: 1px solid black;
        }
        .sect5, td{
            text-align: left;
        }
    </style>

</head>
<body>
    <header class="clearfix">
    <div class="logo">
        <div>
            <img src="{{public_path('img/logo.png')}}" width="200" height="75">
        </div>
        <div id="company" class="infHeader">
            <div>
                <h1>PROCURADURIA GENERAL DEL ESTADO <br>
                    FISCALIA DISTRITO ALTO
                </h1>

            </div>
        </div>
        <div>
            <table class="table-right">
                <thead>
                    <tr>
                        <td>Numero </td>
                        <td>#######</td>
                    </tr>
                    <tr>
                        <td>Fiscalia</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Delito</td>
                        <!--Aqui hay que mandar a llamar al delito si es que ya lo lleva o no? colocare el del que me mandaste -->
                        <td></td>
                    </tr>
                </thead>
            </table>
        </div>
    </table>
    </div>
    </header>
    <h1 class="act">ACTA DE DENUNCIA</h1>
    <div class="parrafo">
        <table border="1">
            <tr>
                <p>Con fundamentos en el articulo 21 parráfo I de la ConstituciónPolitica de los Estados unidos Mexícanos; articulio 109 del codigó Nacional de procedimientos penales.</p>
            </tr>
        </table>
    </div>
    <!--lugar, fecha,hora,ministerio publico-->
    <div class="sect1">
        <table>
            <tr>
                <th>Lugar</th>
                <td>Zacatecas</td>
            </tr>
            <tr>
                <th>Fecha y hora</th>
                <td>{{$report_date}}</td>
            </tr>
            <tr>
                <th>Ministerio Publico</th>
                <td>Quien levanto el Acta</td>
            </tr>
        </table>
    </div><br>
    <div id="sect1" class="sect">
        <table>
            <h3>GENERALES DEL DENUNCIANTE O QUELLANTE</h3>
            <P>Se puede mantener en reserva, con fundamento en el articulo 16, párrafo 2 de La Constitución Politica de los Estados Unidos Mexicanos y  109 del código de procedimientos penales.</P>
        </table>
    </div>
    <div>
        <table>
            <tr>
                <th>Datos reservados</th>
                <td>#####</td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{llaves}} $first_name }} {{llaves}} $last_name }} {{llaves}} $mother_last_name }}</td>
            </tr>
            <tr>
                <th>Curp</th>
                <td>{{llave}} $curp }}</td>
            </tr>
            <tr>
                <th>Domicilio</th>
                <td>{{$street }} {{$ext_number }} {{$int_number }} {{$colony }}</td>
            </tr>
            <tr>
                <th>Codigo Postal</th>
                <td>{{$code_postal}}</td>
            </tr>
            <tr>
                <th>Telefono</th>
                <td>{{$phone}}</td>
            </tr>
            <tr>
                <th>Fecha y Lugar de Nacimiento</th>
                <td>{{$birth_date}} {{$birth_place}}</td>
            </tr>
            <tr>
                <th>Sexo</th>
                <td>{{$sexo}}</td>
            </tr>
            <tr>
                <th>Edad</th>
                <td>{{$age}}</td>
            </tr>
            <tr>
                <th>Estado Civil</th>
                <td>{{$civil_status}}</td>
            </tr>
            <tr>
                <th>Ocupación</th>
                <td>{{$education}}</td>
            </tr>
            <tr>
                <th>Correo</th>
                <td>{{$email }}</td>
            </tr>
        </table>
    </div><br>
    <div class="sect3">
        <h2>NARRACIÓN CIRCUNSTANCIADA DEL HECHO REALIZADA POR EL DENUNCIANTE</h2>
    </div>
    <div class="sect4">
        <table>
            <td>
		//relato de aja
	    </td>
        </table>
    </div>
    <div class="sect5">
        <table>
            <tr>
                <td>Lic. , Agente del Ministerio Publico</td>
                <td></td>
            </tr>
            <tr>
                <td>""{{$first_name }} {{$last_name }} {{$mother_last_name}}"" <br>
                    Persona o Huella del Denunciante o Querrelante</td>
                <td></td>
            </tr>
        </table>
    </div>

</body>
</html>
