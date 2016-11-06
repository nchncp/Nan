<!--  JQUERY -->



	var firebaseDBLink = "https://thesisweb-bd140.firebaseio.com";
	var firebaseTable = new Firebase(firebaseDBLink).child('Questionair');
	var firebaseAnswerTable = new Firebase(firebaseDBLink).child('Answer');
	var firebaseCollectTable = new Firebase(firebaseDBLink).child('Collect');
	var firebaseCollectBoss = new Firebase(firebaseDBLink).child('SelectBoss');
	var firebaseTempAnsForRealTime = new Firebase(firebaseDBLink).child('TempAnswerForGroupMode');

	var Question;
	var Type;
	var correctAnswer;
	var arr =[];
	
	

	

//ListentoFirebase(); // show all data 

function ListentoFirebase(){
	
	firebaseTable.on('value',function(snapshot){
 	var QuestionairData = snapshot.val();
 	var RoomNo = $("#txtRoomNo").val();
 	if(Object.keys(QuestionairData).length>0){
	 
		$.each(QuestionairData,function(index,result){
		var hopperRef = firebaseTable.child(index);	
		//console.log(result);

				if(result.Room == RoomNo && result.GroupMode == "individual" && result.QStatus=='N'){
					//$("#startTest").hide();
						if(result.Type == "Fill in the Blank"){
					//resetNote();
					cancelWriteNote();
					
					var fmodal = document.getElementById('fillModal');
					var fbtn = document.getElementById("fillBtn");
					var span = document.getElementsByClassName("close")[0];
					var note = document.getElementById("startTest");
					
					fmodal.style.display = "block";
					note.style.display = "none";
					Type = result.Type;
				    $HQuestion = $( "#FillintheblankQuestion" ),
		  			Question = result.HQuestion;
		  			$HQuestion.empty();
		  			$HQuestion.append(Question);
		  			
					hopperRef.update({QStatus:'Y'});
		  			
		  			
					}else if(result.Type == "MultipleChoice"){
						//$("#startTest").hide();
						cancelWriteNote();

						//resetNote();
						var cmodal = document.getElementById('choiceModal');
						var cbtn = document.getElementById("choiceBtn");
						var span = document.getElementsByClassName("close")[1];
						var note = document.getElementById("startTest1");
						note.style.display = "none";
			 			cmodal.style.display = "block";
					obj = {C1:result.C1,C2:result.C2,C3:result.C3,HQuestion:result.HQuestion};
					Type = result.Type;
					

					$HQuestion = $( "#MultipleQuestion" ),
		  			Question = obj.HQuestion;
		  			$HQuestion.empty();
		  			$HQuestion.append(Question);

		  			$Choice1 = $( "#Choice1" ),
		  			Choice1 = obj.C1;
		  			$Choice1.append(Choice1);

		  			$Choice2 = $( "#Choice2" ),
		  			Choice2 = obj.C2;
		  			$Choice2.append(Choice2);

		  			$Choice3 = $( "#Choice3" ),
		  			Choice3 = obj.C3;
		  			$Choice3.append(Choice3);

		  			hopperRef.update({QStatus:'Y'});
				}else{
						//resetNote();
						cancelWriteNote();
						var tfmodal = document.getElementById('tfModal');
						var tfbtn = document.getElementById("tfBtn");
						var span = document.getElementsByClassName("close")[2];
						var note = document.getElementById("startTest2");
						note.style.display = "none";
						tfmodal.style.display = "block";
					//true or false
					obj = {HQuestion:result.HQuestion};
					Type = result.Type;
					
					
					$HQuestion = $( "#QuestionTF" ),
		  			Question = obj.HQuestion;
		  			$HQuestion.empty();
		  			$HQuestion.append(Question);
		  			hopperRef.update({QStatus:'Y'});
				}
				}else if(result.Room == RoomNo && result.GroupMode == "group" && result.QStatus=='N'){
				//alert("Prepare for GroupMode");
				//resetNote();
				cancelWriteNote();

				selectBossModal.style.display = "block";
				hopperRef.update({QStatus:'Y'});
				}else{
				//alert("NO ANY QUESTION HERE");
				}
			
		});
	}else{
	//do nothing;
	//console.log('NO ANY QUESTION HERE');
	}
	
	});
}

function ListentoFirebaseForBoss(){
	
	firebaseTable.on('value',function(snapshot){
 	var QuestionairData = snapshot.val();
 	var RoomNo = $("#txtRoomNo").val();
 	if(Object.keys(QuestionairData).length>0){
	 
		$.each(QuestionairData,function(index,result){
		
		if(result.Room == RoomNo){
			if(result.Type == "Fill in the Blank"){
			var fmodal = document.getElementById('fillModal');
			var fbtn = document.getElementById("fillBtn");
			var span = document.getElementsByClassName("close")[0];
			var note = document.getElementById("startTest");
			fmodal.style.display = "block";
			Type = result.Type;
		    $HQuestion = $( "#FillintheblankQuestion" ),
  			Question = result.HQuestion;
  			$HQuestion.empty();
  			$HQuestion.append(Question);
  			
  			
  			
			}else if(result.Type == "MultipleChoice"){
				var cmodal = document.getElementById('choiceModal');
				var cbtn = document.getElementById("choiceBtn");
				var span = document.getElementsByClassName("close")[1];
				var note = document.getElementById("startTest1");
	
	 			cmodal.style.display = "block";
			obj = {C1:result.C1,C2:result.C2,C3:result.C3,HQuestion:result.HQuestion};
			Type = result.Type;
			

			$HQuestion = $( "#MultipleQuestion" ),
  			Question = obj.HQuestion;
  			$HQuestion.empty();
  			$HQuestion.append(Question);

  			$Choice1 = $( "#Choice1" ),
  			Choice1 = obj.C1;
  			$Choice1.append(Choice1);

  			$Choice2 = $( "#Choice2" ),
  			Choice2 = obj.C2;
  			$Choice2.append(Choice2);

  			$Choice3 = $( "#Choice3" ),
  			Choice3 = obj.C3;
  			$Choice3.append(Choice3);


		}else{
						var tfmodal = document.getElementById('tfModal');
				var tfbtn = document.getElementById("tfBtn");
				var span = document.getElementsByClassName("close")[2];
				var note = document.getElementById("startTest2");
				tfmodal.style.display = "block";

				

			//true or false
			obj = {HQuestion:result.HQuestion};
			Type = result.Type;
			
			
			$HQuestion = $( "#QuestionTF" ),
  			Question = obj.HQuestion;
  			$HQuestion.empty();
  			$HQuestion.append(Question);

  			//add for sub in group

		}
		}
		
		});
	}else{
	//do nothing;
	console.log('ERROR OCCUR');
	}
	
	});
}


function CollectScore(RoomNo){
	
	firebaseTable.on('value',function(snapshot){
 	var QuestionData = snapshot.val();
 	
 	$.each(QuestionData,function(index,question){
	firebaseAnswerTable.on('value',function(snapshot){
 	var AnswerData = snapshot.val();
 	
	
 	var showQuestion = question.HQuestion;
	$('#showQuestion').text(showQuestion);
 	
 	var correct=0;
 	var incorrect=0;
 	
 	if(Object.keys(AnswerData).length>0){
 	//question = ('#showQuestion').val();
 	$.each(AnswerData,function(index,result){
 		if(result.Room == RoomNo){
		
				if(result.Type == "MultipleChoice" && result.HQuestion==question.HQuestion){
					      	//var question = question.HQuestion;

							if(result.userAnswer==question.Answer){
									correct++;
									
									
							}else{
									incorrect++;
									
							}
							document.getElementById("correctScore").innerHTML = "";
							document.getElementById("incorrectScore").innerHTML = "";
							$('#correctScore').text(correct);
							$('#incorrectScore').text(incorrect);
							 
							 
						
						//count score 
						}

				else if(result.Type == "True or False" && result.HQuestion==question.HQuestion){
					if(result.userAnswer==question.Answer){
									correct++;
									
							}else{
									incorrect++;
									
							}
							document.getElementById("correctScore").innerHTML = "";
							document.getElementById("incorrectScore").innerHTML = "";
							$('#correctScore').text(correct);
							$('#incorrectScore').text(incorrect);

				}else{ 
						if(question.GroupMode == 'individual'){
							var resultAnswer = result.userAnswer;
							var resultUsername = result.Username;
							var Total = resultAnswer+' '+'('+' '+resultUsername+' '+')'+' ';
							arr.push(Total);
							var html = '';
							for(var i=0 ; i<arr.length;i++) {
									
				  					var temp = arr[i];
				  					
				  					html += '<p>' + temp + '</p></div>';
								}
							
							document.getElementById("correctScore").innerHTML = "";
							document.getElementById("incorrectScore").innerHTML = "";
							document.getElementById("correctScore").innerHTML = html;
							}else{
							var resultAnswer = result.userAnswer;
							var resultUsername = result.Username;
							var Total = resultAnswer+' '+'('+' '+resultUsername+' '+'Group'+')'+' ';
							arr.push(Total);
							var html = '';
							for(var i=0 ; i<arr.length;i++) {
									
				  					var temp = arr[i];
				  					
				  					html += '<p>' + temp + '</p></div>';
								}
							
							document.getElementById("correctScore").innerHTML = "";
							document.getElementById("incorrectScore").innerHTML = "";
							document.getElementById("correctScore").innerHTML = html;
							}
						//loop  show answer
				}


			}
	
		});
			arr.length=0;
}else{
	//alert("NO ANSWER NOWWWWW!!!");
}
		});
	});
	});
}

function CollectFillAnsInGroupMode(resultUsername,resultAnswer){
	arrListGroup =[];
	//check which's group 
	var resultUsername;
	
	firebaseCollectBoss.on('value',function(snapshot){
		var CollectBossData = snapshot.val();
		$.each(CollectBossData,function(index,Group){
			html ='';
			if(Group.Status == "Boss" && Group.Username == resultUsername){
					GroupName = Group.Username +' '+'Group';
					// if boss equal to username who submit ans
			}else if(Group.Status == "Usual" && Group.SubInGroup == resultUsername){
					tmp = Group.Username+',';
					arrListGroup.push(tmp);
					var Total = resultAnswer+' '+'('+' '+tmp+' '+')'+' ';
					html += '<p>' + Total+ '</p></div>';
			}

		});
		document.getElementById("correctScore").innerHTML = html;
	});
}


//submit ANSWER------------------------------------

function submitAnswer(){
var userAnswer = $('#userAnswer');
var UserName = $("#txtUsername").val();
var RoomNo = $("#txtRoomNo").val();
ObjAnswer = {HQuestion:Question,userAnswer:userAnswer.val(),Type:Type,Username:UserName,Room:RoomNo};
console.log(ObjAnswer);
firebaseAnswerTable.push(ObjAnswer);
//popup close 

}


function submitMultipleAnswer(){
var Ans = ($('input[name=ans]:checked').val());
var RoomNo = $("#txtRoomNo").val();
ObjAnswer = {HQuestion:Question,userAnswer:Ans,Type:Type,Room:RoomNo};
console.log(ObjAnswer);
firebaseAnswerTable.push(ObjAnswer);
//popup close 

}

function submitTFAnswer(){
var Ans = ($('input[name=ans]:checked').val());
var RoomNo = $("#txtRoomNo").val();
ObjAnswer = {HQuestion:Question,userAnswer:Ans,Type:Type,Room:RoomNo};
console.log(ObjAnswer);
firebaseAnswerTable.push(ObjAnswer);
//popup close 

}

//submit ANSWER------------------------------------

//multiple
function SubmitMultipleQuestion(){
	QType = "MultipleChoice";
	var RoomNo = $("#txtRoomNo").val();
	QID = guid();
	var GMode = GModearr[0];
	var QStatus = 'N';
	var Ans = ($('input[name=ans]:checked').val());
    var txt ={QID:QID,HQuestion: MP1.val(),C1: MP2.val(),C2: MP3.val(),C3: MP4.val(),Answer: Ans,Type:QType,Room:RoomNo,GroupMode:GMode,QStatus:QStatus};
    	firebaseTable.remove();
    	firebaseAnswerTable.remove();
		firebaseCollectTable.remove();
		firebaseCollectBoss.remove();
       //console.log(txt);
       firebaseTable.push(txt);
			}

//True False

		


function SubmitTFQuestion(){

	QType = "True or False";
	var RoomNo = $("#txtRoomNo").val();
	QID = guid();
	var GMode = GModearr[0];
	var QStatus = 'N';
	var Ans = ($('input[name=ans]:checked').val());
    var txt ={QID:QID,HQuestion: TF1.val(),Answer: Ans,Type:QType,Room:RoomNo,GroupMode:GMode,QStatus:QStatus};
    	firebaseTable.remove();
    	firebaseAnswerTable.remove();
		firebaseCollectTable.remove();
		firebaseCollectBoss.remove();
		       //console.log(txt);
       firebaseTable.push(txt);
       //getPresenterInfo();
              //initialize();
       //debugger;
			}




//FILL in the blank




function SubmitFillQuestion(){
	
	QID = guid();
	var RoomNo = $("#txtRoomNo").val();
	QType = "Fill in the Blank";
	var GMode = GModearr[0];
	var QStatus = 'N';
	var txt ={QID:QID,HQuestion: Fill1.val(),Answer: Ans.val(),Type:QType,Room:RoomNo,GroupMode:GMode,QStatus:QStatus};
		firebaseTable.remove();
    	firebaseAnswerTable.remove();
		firebaseCollectTable.remove();
		firebaseCollectBoss.remove();
    //console.log(txt);

    firebaseTable.push(txt);
 }


function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}

var i;

function ListGroupMode(){

	
	var ListGroup = document.getElementById('ListGroup');
	ListGroup.style.display = "block";


	firebaseCollectBoss.on('value',function(snapshot){

	var arr = [];
 	var selectBossData = snapshot.val();
 	var RoomNo = $("#txtRoomNo").val();

 	if(Object.keys(selectBossData).length>0){
	 
		$.each(selectBossData,function(index,result){
			
				if(result.Status == "Boss" && result.Room == RoomNo){
					var temp = result.Username;
					arr.push(temp);
				}

		});
				var html ='';
				for(i=0; i< arr.length;i++){
					
					 var tmp = arr[i];
					 html += '<option'+' '+'value ='+'"'+tmp+'"'+'>'+ tmp + "Group" + '</option>';
					 //$('#listGroupInfo').append(arr[i]);
					
					/*html = '';
					html += '<p>' + arr[i] + '</p></div>';*/

				}
		document.getElementById("listGroupInfo").innerHTML = "";
		document.getElementById("listGroupInfo").innerHTML = html;
				
				//document.getElementById("ListG").innerHTML = html;
	}else{
	//do nothing;
	alert('ERROR NO DATA');
	}
	
	});

}

function pushUsualInBoss(getInGroupValue){
	var getInGroupValue;
	
	firebaseCollectBoss.on('value',function(snapshot){
	var arrSub =[];
 	var getBossData = snapshot.val();
 	var usualUsername = $("#txtUsername").val();
 	var RoomNo = $("#txtRoomNo").val();
 	if(Object.keys(getBossData).length>0){
	 
		$.each(getBossData,function(index,result){
		
		if(result.Status == "Usual"){
			
				if(result.Room == RoomNo && result.Username == usualUsername){
					var tmp = getInGroupValue;
					
				 	var hopperRef = firebaseCollectBoss.child(index);
					hopperRef.update({SubInGroup:tmp});
				}
			}
		});
	}else{
	//do nothing;
	console.log('NO ANY QUESTION HERE');
	}
	
	});

}

//Real Time Group Mode

function submitToTempAnswer(arrTypeAndAns){
			
	firebaseCollectBoss.on('value',function(snapshot){
		var CollectGroup = snapshot.val();
		$.each(CollectGroup,function(index,Group){
			firebaseTempAnsForRealTime.on('value',function(snapshot){
				var Username = $("#txtUsername").val();
				var RoomNo = $("#txtRoomNo").val();
				var Type = arrTypeAndAns[0];
				var value = arrTypeAndAns[1];
				var forTempAnswer = snapshot.val();
				if(Object.keys(forTempAnswer).length>0){
					$.each(forTempAnswer,function(index,result){
						if(result.Group == Group.Group){
							
							var hopperRef = firebaseTempAnsForRealTime.child(index);
							hopperRef.update({tmpAns:value});

						}else{

						}
					});
				}else{
					//first time input temp dataif(value == 'true' || value == 'false' ){
						if(Group.Username == Username && Group.Status == "Boss"){
							
							txt = {Room:RoomNo,tmpAns:value,Type:Type,Group:Username};
							firebaseTempAnsForRealTime.push(txt);
						}else if(Group.Username == Username && Group.Status == "Usual"){
							var Group = Group.SubInGroup;
							txt = {Room:RoomNo,tmpAns:value,Type:Type,Group:Group};
							firebaseTempAnsForRealTime.push(txt);
						}

				}
			});
		});
	});
}


var arrPassValue =[];
var GroupName;
function getGroupNameInSelectBossTable(Username){
	var Username;
	
	firebaseCollectBoss.on('value',function(snapshot){
		var CollectGroupName = snapshot.val();
		$.each(CollectGroupName,function(index,result){
			

			if(Username==result.Username){
				if(result.Status == 'Boss'){
						GroupName = result.Username +"Group";
						arrPassValue.push(GroupName);
						//return arrPassValue;
						getGroupNameConn(GroupName);
						//return GroupName;
				}else{
						GroupName = result.SubInGroup +"Group";
						arrPassValue.push(GroupName);
						//return arrPassValue;
						getGroupNameConn(GroupName);
						//return GroupName;
				}

			}


		});

	});

	//getGroupName(GroupName);

				
}

/*function checkViewerInRoom(viewerID,Username){
   var viewerID;
   var Username;
   //console.log(viewerID);
   if(viewerID==Username){
    alert("correct");
   }else{
   	alert("not viewer");
   }


}*/
/*var viewerID;
var VUsername;

function getPresenterInfo(){
	debugger;

	//var UserStatus = document.getElementById("hidUserStatus").value;	
	//var PageNo = document.getElementById("pageNumber").value;	
	//var Username = $("#txtUsername").val();
	//var RoomFlag = document.getElementById("hidRoomFlag").value;
	var RoomNo = $("#txtRoomNo").val();
	
	//var RoomCode = document.getElementById("hidRoomCode").value;
	//var Filename = document.getElementById("hidFilename").value;
	$.ajax({
		type: "POST",
		url: "PHPScript/getPresentationInfo.php",
		data: { //txtPageNo: PageNo,
				//txtUsername: Username,
				//hidUserStatus: UserStatus,
				//txtRoomFlag: RoomFlag,
				txtRoomNo: RoomNo,
				//txtRoomCode: RoomCode,
				//txtFilename:Filename
		},
		success: function(data){
			
			$('#spanNowPageNo').html(data);
			//var viewerUsername = document.getElementById("hidViewerName").value;
		    var viewerID = document.getElementById("hidViewerID").value;
		    
			//var viewerID = "ROOT"; // test
			//viewerPopup();
			},
		error:function(){
			//$("#spanMsgError").html("Error setNowPageNo() function !!!");
			alert("FAiled");
			console.log("JSCommFunc.js: Error setNowPageNo() !!!");
		}
	});//END ajax
}//END setNowPageNo()

*/

/*function chkPopup(){
	debugger;
	if(VUsername == viewerID){
		alert("correct");
	}else{
		alert("incorrect");
	}
}*/




  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyC6o5TmanbPladH-j2u3Rw02qw1_I_InBo",
    authDomain: "thesisweb-bd140.firebaseapp.com",
    databaseURL: "https://thesisweb-bd140.firebaseio.com",
    storageBucket: "",
  };
  firebase.initializeApp(config);


