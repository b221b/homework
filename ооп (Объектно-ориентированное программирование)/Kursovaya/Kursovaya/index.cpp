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
        // ������� ��������
        Customer customer;
        customer.numPeople = rand() % 8 + 1; // �� 1 �� 8 祫����
        customer.zone = rand() % CafeConstants::NUM_ZONES + 1;
        customer.tableNumber = -1;
        customer.entranceTime = currentTime;

        // ���� ᢮������� �⮫�
        for (int i = 0; i < CafeConstants::TABLES_PER_ZONE; ++i) {
            int tableIndex = (customer.zone - 1) * CafeConstants::TABLES_PER_ZONE + i;
            if (!tables[tableIndex].occupied) {
                customer.tableNumber = tables[tableIndex].number;
                tables[tableIndex].occupied = true;
                break;
            }
        }

        // ����� ���, ��, ��祭�� � ��ଥ����
        int numCoffees = rand() % 5 + 1; // ����� 祫���� ����� �������� �� 1 �� 5 �襪 ���
        int numTeas = rand() % 3 + 1; // ����� 祫���� ����� �������� �� 1 �� 3 �襪 ��
        int numCookies = rand() % 2 + 1; // ����� 祫���� ����� �������� �� 1 �� 2 ��祭��
        int numMarmalades = rand() % 2 + 1; // ����� 祫���� ����� �������� �� 1 �� 2 ���権 ��ଥ����

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

        // ��室 �� ���
        customer.exitTime = currentTime + (numCoffees + numTeas + numCookies + numMarmalades) * 15; // �६� � ������
        customer.payment = (customer.exitTime - customer.entranceTime) / 60.0 * CafeConstants::HOUR_RATE * customer.numPeople;

        // �뢮� ���ଠ樨
        cout << "Time: " << currentTime / 60 << ":" << currentTime % 60 << endl;
        cout << "Manager: " << managers[customer.zone - 1].name << endl;

        if (customer.tableNumber != -1) {
            printCheck(customer);
        }
        else {
            cout << "No available tables in Zone " << customer.zone << endl;
        }

        // �᢮�������� �⮫�
        if (customer.tableNumber != -1) {
            int tableIndex = (customer.zone - 1) * CafeConstants::TABLES_PER_ZONE + (customer.tableNumber - 1);
            tables[tableIndex].occupied = false;
        }

        // �����祭�� �६���
        currentTime = customer.exitTime;
    }


    return 0;
}