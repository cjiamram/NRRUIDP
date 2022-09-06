<?php
	session_start();
	header("content-type:text/html;charset=UTF-8");
	include_once "../config/database.php";
	include_once "../objects/texpertise.php";
	include_once "../config/config.php";
	$cnf=new Config();
	$rootPath=$cnf->path;

	$database=new Database();
	$db=$database->getConnection();
	$obj=new texpertise($db);

	$userCode=isset($_SESSION["UserName"])?$_SESSION["UserName"]:"";
  $id=$obj->getId($userCode);




?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/froala_editor.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/froala_style.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/code_view.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/draggable.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/colors.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/emoticons.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/image_manager.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/image.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/line_breaker.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/table.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/char_counter.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/video.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/fullscreen.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/file.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/quick_insert.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/help.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/third_party/spell_checker.css">
<link rel="stylesheet" href="<?=$rootPath?>/css/plugins/special_characters.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/froala_editor.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/align.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/emoticons.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/file.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/font_family.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/image.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/inline_style.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/link.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/paragraph_style.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/quick_insert.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/table.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/save.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/url.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/video.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/help.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/print.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/third_party/spell_checker.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/special_characters.min.js"></script>
<script type="text/javascript" src="<?=$rootPath?>/js/plugins/word_paste.min.js"></script>

<section class="content-header">
     <h1>
        <b>ระบบพัฒนาตนเอง</b>

        <small>>>ข้อมูลความเชี่ยวชาญ</small>
      </h1>
      <ol class="breadcrumb">
        <input type="button" id="btnBack"   class="btn btn-primary pull-right"  value="ย้อนกลับ">
      </ol>
    </section>

     <section class="content container-fluid">
     		<div class="box box-warning">
     		<div class="box-body">
     		<div id="dvExpertise">
     			<textarea class="form-control"
                    rows="4" cols="100" 
                    id='obj_expertise'>
                </textarea>
            </div>
           <div class='form-group'><div class="col-sm-12"><hr></div></div>
      <div class='form-group'>
        <div class="col-sm-12">
            <input type="button" id="btnSave" value="บันทึก"  class="btn btn-success">
        </div> 
    </div>
	</div>
</div>

     </section>

    <input id="obj_userCode" type="hidden"  value="<?=$userCode?>">
    <input id="obj_id" type="hidden"  value="<?=$id?>">

 <script>
 	function setTextEditor(obj){
    editor=new FroalaEditor(obj, {
      key: "1C%kZV[IX)_SL}UJHAEFZMUJOYGYQE[\\ZJ]RAe(+%$==",
      attribution: false, // to hide "Powered by Froala"

      toolbarButtons: {
          moreText: {
          // List of buttons used in the  group.
          buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],
          // Alignment of the group in the toolbar.
          align: 'left',
          // By default, 3 buttons are shown in the main toolbar. The rest of them are available when using the more button.
          buttonsVisible: 3
          },

          moreParagraph: {
          buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote'],
          align: 'left',
          buttonsVisible: 3
          },

          moreRich: {
          buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR'],
          align: 'left',
          buttonsVisible: 3
          },

        moreMisc: {
            buttons: ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
            align: 'right',
            buttonsVisible: 2
        }
      },

  
      pastePlain: true,
            language: 'th',
            heightMin: 500,
            heightMax: 500,
            imageUploadURL:"./froala_upload_image.php",
            imageUploadParam:"fileName",
            imageManagerLoadMethod:"GET",
            imageManagerDeleteMethod:"POST",
            // video
            videoUploadURL: './froala_upload_video.php',
            videoUploadParam: 'fileName',
            videoUploadMethod: 'POST',
            videoMaxSize: 50 * 1024 * 1024,
            videoAllowedTypes: ['mp4', 'webm', 'jpg', 'ogg'],
            //file 
            fileUploadURL: './froala_upload_file.php',
            fileUploadParam: 'fileName',
            fileUploadMethod: 'POST',
            fileMaxSize: 20 * 1024 * 1024,
            fileAllowedTypes: ['*'],
  });
  }

  function readExpertise(){
  		var url="<?=$rootPath?>/texpertise/getExpertise.php?userCode="+$("#obj_userCode").val();
  		$("#dvExpertise").load(url);
  }

  function isExist(){
  	var url="<?=$rootPath?>/texpertise/isExist.php?userCode="+$("#obj_userCode").val();
  	var data=queryData(url);
  	return data.flag;
  }

  function createData(){
		var url='texpertise/create.php';
		jsonObj={
			userCode:$("#obj_userCode").val(),
			specialize:$("#obj_expertise").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}
function updateData(){
		var url='texpertise/update.php';
		jsonObj={
			userCode:$("#obj_userCode").val(),
			specialize:$("#obj_expertise").val(),
			id:$("#obj_id").val()
		}
		var jsonData=JSON.stringify (jsonObj);
		var flag=executeData(url,jsonObj,false);
		return flag;
}

function saveData(){
		var flag;
		flag=true;
		if(flag==true){
					if(isExist()===true){
						flag=updateData();
					}else{
						flag=createData();
					}
		if(flag==true){
			swal.fire({
			title: "การบันทึกข้อมูลเสร็จสมบูรณ์แล้ว",
			type: "success",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		}
		else{
			swal.fire({
			title: "การบันทึกข้อมูลผิดพลาด",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
		});
		}
		}else{
			swal.fire({
			title: "รูปแบบการกรอกข้อมูลไม่ถูกต้อง",
			type: "error",
			buttons: [false, "ปิด"],
			dangerMode: true,
			});
			}
}



  $(document).ready(function(){
  	    setTextEditor("#obj_expertise");
  	    readExpertise();

  	    $("#btnBack").click(function(){
  	    	$("#dvMain").load("<?=$rootPath?>/profile/index.php");
  	    });

  	    $("#btnSave").click(function(){
  	    	saveData();
  	    });

  });

 </script>