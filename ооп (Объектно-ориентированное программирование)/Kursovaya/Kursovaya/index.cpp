#include <iostream>
#include <ctime>
#include <cstdlib>
#include <vector>
#include <iomanip>

using namespace std;

class CafeConstants {
public:
    static const int NUM_MANAGERS = 3;
    static const int NUM_ZONES = 3;
    static const int TABLES_PER_ZONE = 3;
    static const int CAFE_OPEN_TIME = 9 * 60;
    static const int CAFE_CLOSE_TIME = 23 * 60;
    static const int HOUR_RATE = 200;
};

class Table {
public:
    int zone;
    int number;
    bool occupied;
};

class Customer {
public:
    int numPeople;
    int zone;
    int tableNumber;
    vector<string> orders;
    int entranceTime;
    int exitTime;
    double payment;
};

class Manager {
public:
    string name;
    int tablesServed; // New variable to track the number of tables served
};

void printCheck(const Customer& customer) {
    cout << setfill('-') << setw(40) << "" << setfill(' ') << endl;
    cout << setw(20) << left << "| Guests arrived: " << setw(19) << right << customer.numPeople << endl;
    cout << setw(20) << left << "| Hall: " << setw(19) << right << customer.zone << endl;
    cout << setw(20) << left << "| Table: " << setw(19) << right << customer.tableNumber << endl;
    cout << setw(20) << left << "| Orders: ";
    for (const string& order : customer.orders) {
        cout << order << " ";
    }
    cout << setw(18) << right << endl;

    cout << setw(20) << left << "| Start time: " << setw(18) << right << customer.entranceTime / 60 << ":" << customer.entranceTime % 60 << endl;

    // Adjust exit time to wrap around to the next day if needed
    int exitHours = customer.exitTime / 60 % 24;
    int exitMinutes = customer.exitTime % 60;
    cout << setw(20) << left << "| Exit time: " << setw(18) << right << exitHours << ":" << exitMinutes << endl;

    cout << setw(20) << left << "| Payment: " << setw(18) << right << customer.payment << " rubles " << endl;
    cout << setfill('-') << setw(40) << "" << setfill(' ') << endl;
}

int main() {
    srand(time(0));

    Manager managers[CafeConstants::NUM_MANAGERS] = { {"Manager 1"}, {"Manager 2"}, {"Manager 3"} };
    Table tables[CafeConstants::NUM_ZONES * CafeConstants::TABLES_PER_ZONE];

    for (int i = 0; i < CafeConstants::NUM_ZONES * CafeConstants::TABLES_PER_ZONE; ++i) {
        tables[i].zone = i / CafeConstants::TABLES_PER_ZONE + 1;
        tables[i].number = i % CafeConstants::TABLES_PER_ZONE + 1;
        tables[i].occupied = false;
    }

    int currentTime = CafeConstants::CAFE_OPEN_TIME;

    int maxTablesServedByManager = 0;
    string managerWithMaxTablesServed;

    int maxTableUsage = 0;
    int mostDemandedTableNumber;

    int maxCustomersAtTable = 0;
int tableWithMaxCustomers;

    while (currentTime <= CafeConstants::CAFE_CLOSE_TIME) {
        // Генерация компании
        Customer customer;
        customer.numPeople = rand() % 8 + 1; // от 1 до 8 человек
        customer.zone = rand() % CafeConstants::NUM_ZONES + 1;
        customer.tableNumber = -1;
        customer.entranceTime = currentTime;

        // Поиск свободного стола
        for (int i = 0; i < CafeConstants::TABLES_PER_ZONE; ++i) {
            int tableIndex = (customer.zone - 1) * CafeConstants::TABLES_PER_ZONE + i;
            if (!tables[tableIndex].occupied) {
                customer.tableNumber = tables[tableIndex].number;
                tables[tableIndex].occupied = true;
                break;
            }
        }

        // Заказ кофе, чая, печенья и мармелада
        int numCoffees = rand() % 5 + 1; // каждый человек может заказать от 1 до 5 чашек кофе
        int numTeas = rand() % 3 + 1; // каждый человек может заказать от 1 до 3 чашек чая
        int numCookies = rand() % 2 + 1; // каждый человек может заказать от 1 до 2 печенек
        int numMarmalades = rand() % 2 + 1; // каждый человек может заказать от 1 до 2 порций мармелада

        for (int i = 0; i < numCoffees; ++i) {
            customer.orders.push_back("Coffee");
        }

        for (int i = 0; i < numTeas; ++i) {
            customer.orders.push_back("Tea");
        }

        for (int i = 0; i < numCookies; ++i) {
            customer.orders.push_back("Cookie");
        }

        for (int i = 0; i < numMarmalades; ++i) {
            customer.orders.push_back("Marmalade");
        }

        // Выход из кафе
        customer.exitTime = currentTime + (numCoffees + numTeas + numCookies + numMarmalades) * 15; // время в минутах
        customer.payment = (customer.exitTime - customer.entranceTime) / 60.0 * CafeConstants::HOUR_RATE * customer.numPeople;

        // Вывод информации
        cout << "Time: " << currentTime / 60 << ":" << currentTime % 60 << endl;
        cout << "Manager: " << managers[customer.zone - 1].name << endl;

        if (customer.tableNumber != -1) {
            printCheck(customer);
        }
        else {
            cout << "No available tables in Zone " << customer.zone << endl;
        }

        // Освобождение стола
        if (customer.tableNumber != -1) {
            int tableIndex = (customer.zone - 1) * CafeConstants::TABLES_PER_ZONE + (customer.tableNumber - 1);
            tables[tableIndex].occupied = false;
        }

        // Увеличение времени
        currentTime = customer.exitTime;
    }


    return 0;
}