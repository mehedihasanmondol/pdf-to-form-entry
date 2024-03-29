
<html lang="en"><head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->


    <!-- Google Fonts -->
    <!--<link href="https://fonts.gstatic.com" rel="preconnect">-->
    <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">-->

    <!--&lt;!&ndash; Vendor CSS Files &ndash;&gt;-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">-->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.5.2/css/bootstrap.min.css" rel="stylesheet">-->
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css" rel="stylesheet">-->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" rel="stylesheet">-->
    <!--<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">-->
    <!--<link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">-->
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.94/remixicon.css" rel="stylesheet">-->
    <!--<link href="https://cdn.jsdelivr.net/npm/simple-datatables@6.1.0/style.css" rel="stylesheet">-->


    <!--&lt;!&ndash; Template Main CSS File &ndash;&gt;-->
    <!--<link href="assets/css/styleX.css" rel="stylesheet">-->
    <style>
        /* Style for all div elements within the form */
        /* Style for the button */
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        /* Style for the button on hover */
        .button:hover {
            background-color: #0056b3; /* Change the background color on hover */
            transform: scale(1.1); /* Scale the button slightly on hover */
        }

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
<?php
    $pdf_data = array(
        "officeAddress2" => "",
        "dor" => "",
        "officeAddress1" => "",
        "doi" => "",
        "date" => "",
        "brn" => "",
        "sex" => "",
        "name_bangla" => "",
        "name_english" => "",
        "pob_bangla" => "",
        "pob_english" => "",
        "mother_bangla" => "",
        "mother_english" => "",
        "mother_n_bangla" => "বাংলাদেশী",
        "mother_n_english" => "BANGLADESHI",
        "father_bangla" => "",
        "father_english" => "",
        "father_n_bangla" => "বাংলাদেশী",
        "father_n_english" => "BANGLADESHI",
    );
    if(isset($_FILES['multiplefileupload'])){
        require_once 'pdfDataExtractor.php';
        $pdf_data = extract_data($_FILES['multiplefileupload']['tmp_name']);
    }

    //you can print this $pdf_data variable. all extracted data here
    echo "<pre>";
    print_r($pdf_data);
    echo "</pre>";

?>



<!-- ======= Header ======= -->

<form action="" method="POST" accept-charset="utf-8" id="form" enctype="multipart/form-data">
    <label for="multiplefileupload">
        <!-- Add your label content if needed -->
    </label>
    <input id="multiplefileupload" type="file" name="multiplefileupload" accept=".pdf" style="display: block;" onchange="autoSubmit()" required>
</form>

<script>

    function autoSubmit() {
        $("#form").submit();
    }

    // $(document).ready(function () {
    //     console.log($("#form"))
    //     $("#form").submit(function (e) {
    //
    //         e.preventDefault();
    //
    //         // Create a FormData object from the form
    //         var formData = new FormData(this);
    //
    //         // Make an AJAX request using jQuery
    //         $.ajax({
    //             url: 'getPDFdata.php',
    //             type: 'POST',
    //             data: formData,
    //             processData: false,  // Prevent jQuery from processing the data
    //             contentType: false,  // Prevent jQuery from setting the content type
    //             success: function(response) {
    //                 var json_data = JSON.parse(response);
    //                 Object.keys(json_data).forEach(function (key) {
    //                     $("#"+key).val(json_data[key])
    //                 });
    //
    //
    //             },
    //             error: function(error) {
    //                 console.error('Error:', error);
    //             }
    //         });
    //     })
    // });
</script>

<main id="main" class="main">
    <section class="section">

        <form action="cer.php" target="_BLANK" method="POST">
            <div id="app">
                <div class="main-wrapper main-wrapper-1">
                    <div class="main-content" style="min-height: 530px;">
                        <section class="bg-diffrent">
                            <div class="container">


                                <input type="text" name="lang" value="bn" style="display: none;">





                                <div class="row mt-5">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Birth Register Office Name in English</label>
                                            <input type="text" name="officeAddress1" id="officeAddress1" class="form-control" placeholder="Jamalpur Union Parishad" value="<?php echo $pdf_data['officeAddress1'];  ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Birth Register Office Address in English</label>
                                            <input type="text" name="officeAddress2" id="officeAddress2" class="form-control" placeholder="UpzilaName, Zila" value="<?php echo $pdf_data['officeAddress2'];  ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Birth Registration Number</label>
                                            <div id="brn-error" class="error-message" style="color: red; display: none;">Please input 17 Digits Birth Register Number.</div>
                                            <input type="text" name="brn" id="brn" class="form-control" placeholder="Input 17 digits Birth Register Number" required pattern="[0-9]{17}" title="Please enter a 17-digit number" value="<?php echo $pdf_data['brn'];  ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Date of Registration</label>
                                            <div id="dor-error" class="error-message" style="color: red; display: none;">Invalid date format. Use DD/MM/YYYY format.</div>
                                            <input type="text" name="dor" id="dor" class="form-control" placeholder="অনলানে যে তারিখ আছে । DD/MM/YYYY" pattern="^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$" required value="<?php echo $pdf_data['dor'];  ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Date of Issuance</label>
                                            <div id="doi-error" class="error-message" style="color: red; display: none;">Invalid date format. Use DD/MM/YYYY format.</div>
                                            <input type="text" name="doi" id="doi" class="form-control" placeholder="অনলানে যে তারিখ আছে । DD/MM/YYYY" pattern="^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}$" required value="<?php echo $pdf_data['doi'];  ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Date of Birth</label>

                                            <div id='date_string'></div>
                                            <input type="text" name="date" id="date"  value="<?php echo $pdf_data['date'];  ?>">


                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Gender</label>
                                            <select name="sex" id="sex" class="form-select">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">নাম (বাংলা)</label>
                                            <input type="text" name="name_bangla" id="name_bangla" class="form-control" placeholder="বাংলায় নাম লেখুন..." value="<?php echo $pdf_data['name_bangla'];  ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Name(English)</label>
                                            <input type="text" name="name_english" id="name_english" class="form-control" placeholder="Type your name in English..." value="<?php echo $pdf_data['name_english'];  ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">পিতা নাম (বাংলা)</label>
                                            <input type="text" name="father_bangla" id="father_bangla" class="form-control" placeholder="পিতার নাম বাংলায় লেখুন..." value="<?php echo $pdf_data['father_bangla'];  ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Father Name(English)</label>
                                            <input type="text" name="father_english" id="father_english" class="form-control" placeholder="Father's name in English..." value="<?php echo $pdf_data['father_english'];  ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">মাতার নাম (বাংলা)</label>
                                            <input type="text" name="mother_bangla" id="mother_bangla" class="form-control" placeholder="মাতার নাম বাংলায় লেখুন..." value="<?php echo $pdf_data['mother_bangla'];  ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Mother Name(English)</label>
                                            <input type="text" name="mother_english" id="mother_english" class="form-control" placeholder="Mother's name in English..." value="<?php echo $pdf_data['mother_english'];  ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">জন্মস্থান (বাংলা) জেলা, দেশ</label>
                                            <input type="text" name="pob_bangla" id="pob_bangla" class="form-control"  value="<?php echo $pdf_data['pob_bangla'];  ?>" placeholder="জন্মস্থান লেখুন...">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Place of Birth(English) Zila,Country</label>
                                            <input type="text" name="pob_english" id="pob_english" class="form-control"  value="<?php echo $pdf_data['pob_english'];  ?>" placeholder=" Your place of birth...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">স্থায়ী ঠিকানা (বাংলা)</label>
                                            <textarea name="permanent_bangla" id="permanent_bangla" cols="60" rows="2" class="form-control" placeholder="স্থায়ী ঠিকানা বাংলায় লেখুন...">গ্রাম, ডাকঘর,,

											</textarea>

                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Permanent(English)</label>
                                            <textarea name="permanent_english" id="permanent_english" cols="60" rows="2" class="form-control" placeholder="Permanent Address in English...">Village PostOffice,,

											</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">পিতার জাতীয়তা (বাংলা)</label>
                                            <input type="text" name="father_n_bangla" id="father_n_bangla" class="form-control"  value="<?php echo $pdf_data['father_n_bangla'];  ?>" placeholder="পিতার জাতীয়তা লেখুন...">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Father Nationality(English)</label>
                                            <input type="text" name="father_n_english" id="father_n_english" class="form-control"  value="<?php echo $pdf_data['father_n_english'];  ?>" placeholder="Inter your father nationality...">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">মাতার জাতীয়তা (বাংলা)</label>
                                            <input type="text" name="mother_n_bangla" id="mother_n_bangla" class="form-control"  value="<?php echo $pdf_data['mother_n_bangla'];  ?>" placeholder="মাতার জাতীয়তা লেখুন...">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="first">Mother Nationality(English)</label>
                                            <input type="text" name="mother_n_english" id="mother_n_english" class="form-control"  value="<?php echo $pdf_data['mother_n_english'];  ?>" placeholder="Inter your mother nationality...">
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content: center; margin-bottom: 50px;">
                                    <button class="button">button</button></div>
                            </div>
                            <div style="display: flex; justify-content: center; margin-bottom: 50px;">

                            </div>

                    </div>
    </section>
    </div>
    </div>
    </div>


    </form>
    <!-- Existing HTML code here -->




    </section>
</main>


<input type="hidden" id="CUSTOMSESSIONID" value="/ev6qim9yF/lgI0QAtFBiUxBdTFZWVU2MlVjQ2JKK2Q4NC9MOUVMYW1SUFE3VjgzdldWcWRCb2wybkk9">
<input type="hidden" id="TS01be4f8c" value="/ev6qim9yF/lgI0QAtFBiUxBdTFZWVU2MlVjQ2JKK2Q4NC9MOUVMYW1SUFE3VjgzdldWcWRCb2wybkk9">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // JavaScript to show individual error messages for each date field
    const dateFields = document.querySelectorAll("#brn, #dob, #dor, #doi");

    dateFields.forEach(function(input) {
        const errorDiv = document.querySelector(`#${input.id}-error`);
        input.addEventListener("input", function() {
            if (!this.validity.valid) {
                errorDiv.style.display = "block";
            } else {
                errorDiv.style.display = "none";
            }
        });
    });
</script>
<!-- ======= Footer ======= -->


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!--&lt;!&ndash; Vendor JS Files &ndash;&gt;-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.1/apexcharts.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.5.2/js/bootstrap.bundle.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.2/echarts.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/simple-datatables/3.3.0/simple-datatables.js"></script>-->
<!--<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/php-email-form/3.2.2/validate.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->


<!--&lt;!&ndash; Template Main JS File &ndash;&gt;-->
<!--<script src="assets/js/main.js"></script>-->




</body>
</html>