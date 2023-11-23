let data = [
    { id: 1, name: "qwe", email: "qwe@gmail.com" },
    { id: 2, name: "ewq", email: "ewq@gmail.com" }

]

function readAll() {
    localStorage.setItem("object", JSON.stringify(data));
    var tableData = document.querySelector(".data_table");

    var object = localStorage.getItem('object');
    var objectdata = JSON.parse(object);
    var elements = "";

    objectdata = JSON.parse(object);
    var elements = "";

    objectdata.map(record => (
        elements += `<tr>
        <td>${record.name}</td>
        <td>${record.email}</td>
        <td>
            <button>Изменить</button>
            <button>Удалить</button>
        </td>
        </tr>`
    ))

    tableData.innerHTML = elements;

}

function create(){
    document.querySelector(".create_form").style.display = "block";
    document.querySelector(".add_div").style.display = "none";
}

function add(){
    var name = document.querySelector(".name").value;
    var email = document.querySelector(".email").value;

    var newObj = {id: 3, name: name, email: email};
    data.push(newObj);

    document.querySelector(".create_form").style.display = "none";
    document.querySelector(".add_div").style.display = "block";

    readAll();
}