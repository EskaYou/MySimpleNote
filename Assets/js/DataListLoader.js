/*
  Rizky Maulana 003 | Untuk keperluan DOM dan JSON request
*/


var notes = [];
var note_list = document.querySelector("#note-list");

// Buttons
var OnSaveNote = document.querySelector("#OnSaveNoteBtn");
var OnShowAddForm = document.querySelector("#OnBtnAdd");
var OnEditNote = document.querySelector("#OnBtnEditNote");
var OnBackToHome = document.querySelector("#OnBtnBackToHomePage");
var OnBtnDelete = document.querySelector("#OnBtnDeleteNote");
var button_click_index = 1;


// Note container
var note_list_container = document.querySelector("#note-list-container");
var note_detail_container = document.querySelector("#note-detail");
var note_form_container = document.querySelector("#note-form-container");
note_list_container.style.display = "block"; // sebelumnya block 
note_form_container.style.display = "none"; // sebelumnya none
note_detail_container.style.display = "none";


// Form
var current_date = new Date();
var title_input = document.querySelector("#title");
var text_input = document.querySelector("#text");
var user_input = document.querySelector("#user-form");
var note_input = document.querySelector("#note-form");
var note_date = current_date.getFullYear() + "-"  + (current_date.getMonth() + 1) + "-" + current_date.getDate();


// Note detail
var note_detail_title = document.querySelector("#note-detail-title-data");
var note_detail_text = document.querySelector("#note-detail-text-data");
var note_detail_content = document.querySelector("#note-detail-content");
var note_detail_id = document.querySelector("#note-detail-id");


// Additional content
//var content_title = document.querySelector("#content-title");

var is_editing = false;

function ResetForm()
{
    title_input.value = "";
    text_input.value= "";
    note_date = "";
    note_input.value = "";
    is_editing = false;
}

function GetNoteDetail(note_id)
{
    //content_title.style.display = "none";
    note_list_container.style.display = "none";
    note_form_container.style.display = "none";
    note_detail_container.style.display = "block";
    note_detail_content.style.display = "block";
    OnBtnDelete.style.display = "inline";

    var data = new XMLHttpRequest(); 
    data.addEventListener("load", function(e){
	var note_detail = JSON.parse(e.srcElement.responseText);
	// Masukan data ke dalam elemen html
	note_detail_title.textContent = note_detail.title;
	note_detail_text.textContent = note_detail.text;
	note_detail_id.textContent = note_detail.id;

	// Masukan data ke dalam form
	title_input.value = note_detail.title;
	text_input.value = note_detail.text;
	note_input.value = note_id;
    });
    data.open("GET", "Webservice/getsingledata.php?user=" + user + "&note=" + note_id, true);
    data.send();
}

function CreateList()
{
    for(let i = 0; i < notes.length; i++)
    {
	var id = notes[i].id;
	var title = notes[i].title;
	var text = notes[i].text;
	var user = notes[i].nama;
	var created_at = notes[i].created_at;
	
	var item = document.createElement("div");
	item.setAttribute("id", "d-" + id);
	item.className = "item";
	item.innerHTML = `
           <div class="inner-item" onclick="GetNoteDetail(` + id  + `);">
		<div class="container">
		    <h2 class="item-title">` + title + `</h2>
		    <span class="item-date">` + `Dibuat pada: ` + created_at  + ` | ` + user + `</span>
		    <p class="item-text-preview">` + text.slice(0, 100) + `</p>
		</div>
	    </div>`;
	note_list.appendChild(item);
    }
}

function LoadAllData(user)
{
    var user_data = user;

    var xml_data = new XMLHttpRequest();
    xml_data.onreadystatechange = function()
    {
    	 if(this.readyState == 4 && this.status == 200)
    	 {
	     var note_data = JSON.parse(this.responseText);
	     for(let i = 0; i < note_data.length; i++)
	     {
		 var obj = {
		     id: note_data[i].id,
		     title: note_data[i].title,
		     text: note_data[i].text,
		     nama: note_data[i].nama,
		     created_at: note_data[i].created_at
		 };

		 notes.push(obj);
	     }
	     CreateList();
    	 }	 
    }
    
    xml_data.open("GET", "Webservice/getalldata.php?user=" + user_data, true);
    xml_data.send();
}


OnSaveNote.addEventListener("click", function(e){
    e.preventDefault();
    
    if(title.value != "" && text.value != "")
    {
	var note_form = document.querySelector("#note_form");
	var note_form_data = new FormData(note_form);
	var data = new XMLHttpRequest();

	var get_data = new Object();
	if(is_editing === false)
	{
	    console.log("Save data");
	    // Save data
	    data.addEventListener("load", function(e){
		var current_data = JSON.parse(e.target.responseText);
		get_data = {
		    id: current_data.id,
		    title: current_data.title,
		    text: current_data.text,
		    nama: current_data.nama,
		    created_at: current_data.created_at
		};
		notes.push(get_data);
		CreateList();
	    });
	    data.addEventListener("error", function(e){
		console.log(e.target.responseText);
	    });
	    data.open("POST", "Webservice/savedata.php", true);
	    data.send(note_form_data);
	}
	else
	{
	    // Update data
	    console.log("Update data");
	    data.addEventListener("load", function(e){
		var current_data = JSON.parse(e.target.responseText);
		notes = [];
		LoadAllData(user);
		GetNoteDetail(current_data.id);
	    });
	    data.addEventListener("error", function(e){
		console.log(e.target.responseText);
	    });
	    data.open("POST", "Webservice/updatedata.php", true);
	    data.send(note_form_data);
	    is_editing = false;
	}
	

	// Reset form
	ResetForm();

	// Reset note list item
	if(notes.length > 0)
	{
	    for(let i = 0; i < notes.length; i++)
	    {
		var del_item = document.querySelector(".item");
		note_list.removeChild(del_item);
	    }
	}

	// Reset view
	if(is_editing === false)
	{
	    button_click_index = 1;
	    OnShowAddForm.textContent = "+";
	    note_list_container.style.display = "block";
	    note_form_container.style.display = "none";
	}
	else
	{
	    // Apa?
	}
    }
    else
    {
	alert("Judul atau konten tidak boleh kosong");
    }
});


OnShowAddForm.addEventListener("click", function(e){
    e.preventDefault();
    button_click_index++;

    ResetForm();
    
    note_detail_container.style.display = "none";
    if(button_click_index % 2 == 0)
    {
	this.textContent = "<";
	note_list_container.style.display = "none";
	note_form_container.style.display = "block";
    }
    else
    {
	this.textContent = "+";
	note_list_container.style.display = "block";
	note_form_container.style.display = "none";
    }
});


OnBackToHome.addEventListener("click", function(e){
    e.preventDefault();

    //note_form_container.style.display = "none";
    //note_detail_container.style.display = "none";
    //note_list_container.style.display = "block";

    // Reset notes array
    // Sudahlah....., terlalu malas untuk membuat fungsi DOM-nya
    location.reload();
});


OnEditNote.addEventListener("click", function(e){
    e.preventDefault();
    is_editing = true;
    
    // tampilkan edit form
    note_form_container.style.display = "block";
    note_detail_content.style.display = "none";
    OnBtnDelete.style.display = "none";
});


OnBtnDelete.addEventListener("click", function(e){
    e.preventDefault();
    var ask = confirm("Kamu yakin ingin menghapus catatan ini?");
    if(ask === true)
    {
	var form_data = new FormData();
	form_data.append("note", note_detail_id.textContent);
	
	var data = new XMLHttpRequest();
	console.log("Hapus data");
	data.addEventListener("load", function(e){
	    console.log(e.target.responseText);
	});
	data.addEventListener("error", function(e){
		console.log(e.target.responseText);
	});
	data.open("POST", "Webservice/deletedata.php", true);
	data.send(form_data);

	// Reset notes array
	// Sudahlah....., terlalu malas untuk membuat fungsi DOM-nya
	location.reload();
    }
    else
    {
	console.log("Nggak jadi");
    }
    
});
