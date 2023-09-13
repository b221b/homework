		/* Задание_1 */

/*
var x = 10;
var y = 15;
var z = 10;

var result = x + y / z;

alert(result);
*/

		/* Задание_2 */

/*
let s1 = 123;
let s2 = 456;
let s3 = "name";

var n = 123;

alert(s1+s2); 
alert(n+s2); 
alert(n+s3);
*/

		/* Задание_3 */

/*
var num1 = 123;
var num2 = 456;
		
var resultString = "Результат = " + (num1 + num2);
		
alert(resultString);
*/

		/* Задание_4 */

/*
function isPalindrome(str) {
    str = str.replace(/\s/g, '').toLowerCase();
    return str === str.split('').reverse().join('');
}

var poly = "abcdedcba";
var test = "teststring";

var isPoly = isPalindrome(poly); 
var isTest = isPalindrome(test); 

alert("poly является палиндромом:", isPoly);
alert("test является палиндромом:", isTest);
*/

		/* Задание_5 */

/*
function findMaxOfThreeNumbers(num1, num2, num3) {
    if (num1 >= num2 && num1 >= num3) {
        return num1;
    } else if (num2 >= num1 && num2 >= num3) {
        return num2;
    } else {
        return num3;
    }
}

var number1 = 765;
var number2 = 3457;
var number3 = 232;

var maxNumber = findMaxOfThreeNumbers(number1, number2, number3);

alert("Наибольшее число: " + maxNumber);
*/

		/* Задание_6 */
/*

var side1 = parseFloat(prompt("Введите длину первой стороны треугольника:"));
var side2 = parseFloat(prompt("Введите длину второй стороны треугольника:"));
var side3 = parseFloat(prompt("Введите длину третьей стороны треугольника:"));

function calculateTriangleArea(a, b, c) {
    
    var s = (a + b + c) / 2; // Полупериметр
    
    var area = Math.sqrt(s * (s - a) * (s - b) * (s - c)); // Площадь по формуле Герона
    return area;
}

var area = calculateTriangleArea(side1, side2, side3); // Вычисляем площадь для введенных сторон

alert("Площадь треугольника: " + area); // Выводим результат

var area1 = calculateTriangleArea(5, 6, 7); // Проверка для значений сторон 5, 6, 7
alert("Площадь треугольника со сторонами 5, 6, 7: " + area1);

var area2 = calculateTriangleArea(10, 12, 25); // Проверка для значений сторон 10, 12, 25
alert("Площадь треугольника со сторонами 10, 12, 25: " + area2);
*/
		/* Задание_7 */
/*

var number = parseFloat(prompt("Введите число:"));

switch (number) {
  case 1:
    alert("Равно 1");
    break;
  case 2:
    alert("Равно 2");
    break;
  case 3:
    alert("Равно 3");
    break;
  default:
    alert("Не Равно 1, 2, 3");
}

*/

		/* Задание_8 */
/*
function getDayOfWeek(number) {
    switch (number) {
        case 1:
            return "Понедельник";
        case 2:
            return "Вторник";
        case 3:
            return "Среда";
        case 4:
            return "Четверг";
        case 5:
            return "Пятница";
        case 6:
            return "Суббота";
        case 7:
            return "Воскресенье";
        default:
            return "не подходящее число, попробуй заново";
    }
}

var dayNumber = parseFloat(prompt("Введите число от 1 до 7:"));
var dayOfWeek = getDayOfWeek(dayNumber);
alert("День недели: " + dayOfWeek);
*/

		/* Задание_9 */
/*
var someValue = 12; 
var defaultValue = "Значение по умолчанию";
var result = someValue ?? defaultValue;

alert(result);
*/