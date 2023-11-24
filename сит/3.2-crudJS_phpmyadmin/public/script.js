// var selectedRow = null;

// function onFormSubmit() {
//     if (validate()) {
//         var formData = readFormData();
//         if (selectedRow == null)
//             insertNewRecord(formData);
//         else
//             updateRecord(formData);
//         resetForm();
//     }
// }

// function readFormData() {
//     var formData = {};
//     formData["id"] = document.getElementById("id").value;
//     formData["name_firma"] = document.getElementById("name_firma").value;
//     formData["phone"] = document.getElementById("phone").value;
//     formData["email"] = document.getElementById("email").value;
//     formData["website"] = document.getElementById("website").value;
//     formData["city"] = document.getElementById("city").value;
//     formData["flag"] = document.getElementById("flag").value;
//     return formData;
// }

// function insertNewRecord(data) {
//     var table = document.getElementById("employeeList").getElementsByTagName('tbody')[0];
//     var newRow = table.insertRow(table.length);
//     cell1 = newRow.insertCell(0);
//     cell1.innerHTML = data.id;
//     cell2 = newRow.insertCell(1);
//     cell2.innerHTML = data.name_firma;
//     cell3 = newRow.insertCell(2);
//     cell3.innerHTML = data.phone;
//     cell4 = newRow.insertCell(3);
//     cell4.innerHTML = data.email;
//     cell5 = newRow.insertCell(4);
//     cell5.innerHTML = data.website;
//     cell6 = newRow.insertCell(5);
//     cell6.innerHTML = data.city;
//     cell7 = newRow.insertCell(6);
//     cell7.innerHTML = `<a onClick="onEdit(this)">Edit</a>
//                        <a onClick="onDelete(this)">Delete</a>`;
// }

// function resetForm() {
//     document.getElementById("id").value = "";
//     document.getElementById("name_firma").value = "";
//     document.getElementById("phone").value = "";
//     document.getElementById("email").value = "";
//     document.getElementById("website").value = "";
//     document.getElementById("city").value = "";
//     document.getElementById("flag").value = "";
//     selectedRow = null;
// }

// function onEdit(td) {
//     selectedRow = td.parentElement.parentElement;
//     document.getElementById("id").value = selectedRow.cells[0].innerHTML;
//     document.getElementById("name_firma").value = selectedRow.cells[1].innerHTML;
//     document.getElementById("phone").value = selectedRow.cells[2].innerHTML;
//     document.getElementById("email").value = selectedRow.cells[3].innerHTML;
//     document.getElementById("website").value = selectedRow.cells[4].innerHTML;
//     document.getElementById("city").value = selectedRow.cells[5].innerHTML;
//     document.getElementById("flag").value = selectedRow.cells[6].innerHTML;
// }

// function updateRecord(formData) {
//     selectedRow.cells[0].innerHTML = formData.id;
//     selectedRow.cells[1].innerHTML = formData.name_firma;
//     selectedRow.cells[2].innerHTML = formData.phone;
//     selectedRow.cells[3].innerHTML = formData.email;
//     selectedRow.cells[4].innerHTML = formData.website;
//     selectedRow.cells[5].innerHTML = formData.city;
//     selectedRow.cells[6].innerHTML = formData.flag;
// }

// function onDelete(td) {
//     if (confirm('Are you sure to delete this record ?')) {
//         row = td.parentElement.parentElement;
//         document.getElementById("employeeList").deleteRow(row.rowIndex);
//         resetForm();
//     }
// }

// function validate() {
//     isValid = true;
//     if (document.getElementById("fullName").value == "") {
//         isValid = false;
//         document.getElementById("fullNameValidationError").classList.remove("hide");
//     } else {
//         isValid = true;
//         if (!document.getElementById("fullNameValidationError").classList.contains("hide"))
//             document.getElementById("fullNameValidationError").classList.add("hide");
//     }
//     return isValid;
// }