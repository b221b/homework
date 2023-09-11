#include <iostream>
using namespace std;

int main()
{
        /*Задание_1*/

    /* Пример_1*/
    int var1;
    int var2;
    var1 = 20;
    var2 = var1 + 10;
    cout << "var1 + 10 ravno";
    cout << var2 << endl;

    /* Пример_2
    char charvar1 = 'A';

    char charvar2 = '\t';
    cout << charvar1;
    cout << charvar2;
    charvar1 = 'B';

    cout << charvar1;
    cout << '\n'; */

    /* Пример_3
    float rad;
    const float PI = 3.14159F;
    cout << "Vvedite radius okryzhnosti: ";
    cin >> rad;
    float area = PI * rad * rad;
    cout << "Ploshad' kryga ravna " << area << endl;*/

    return 0;
}
    /*Задание_2 Var5
    #include <iostream>
    #include <cstring>
    using namespace std;

    class Kvitanziya // определение класса
    {
    private:
        int number;
        char date[15];// string date;
        float amount;

    public:
    //добавить функции set как и get, для каждой
     int getNumber(){
        return number;
    }

    const char* getDate(){
        return date;
    }

    float getAmount(){
        return amount;
    }

    int set Number(){
        return number;
    }

    int set Date(){
        return Date;
    }

    int set Amount(){
        return Amount;
    }
    };



    int main() {
    Kvitanziya kv(1234, "01.01.2023", 15000);

    cout<<"Nomer kvitanzii: " << kv.getNumber() << endl;
    cout<<"Data: " << kv.getDate() << endl;
    cout<<"Summ: " << kv.getAmount() << endl;
    return 0;
}

}
*/
