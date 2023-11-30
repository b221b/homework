#include <iostream>
#include <vector>
#include <string>
#include <sstream>

class Table {
public:
    Table(int number) : number(number), reserved(false), reservedBy("") {}

    int getNumber() const {
        return number;
    }

    bool isReserved() const {
        return reserved;
    }

    const std::string& getReservedBy() const {
        return reservedBy;
    }

    void reserve(const std::string& name) {
        reserved = true;
        reservedBy = name;
    }

    void free() {
        reserved = false;
        reservedBy = "";
    }
    
private:
    int number;
    bool reserved;
    std::string reservedBy;
};

class Manager {
public:
    void addTable(const Table& table) {
        tables.push_back(table);
    }

    void reserveTable(int tableNumber, const std::string& name) {
        for (Table& table : tables) {
            if (table.getNumber() == tableNumber) {
                if (!table.isReserved()) {
                    table.reserve(name);
                    std::cout << "Table " << tableNumber << " successfully taken for " << name << "\n" << std::endl;
                }
                else {
                    std::cout << "Table " << tableNumber << " already taken" << "\n" << std::endl;
                }
                return;
            }
        }
        std::cout << "Table " << tableNumber << " not found" << "\n" << std::endl;
    }

    void freeTable(int tableNumber) {
        for (Table& table : tables) {
            if (table.getNumber() == tableNumber) {
                if (table.isReserved()) {
                    table.free();
                    std::cout << "Table " << tableNumber << " released" << "\n" << std::endl;
                }
                else {
                    std::cout << "Table " << tableNumber << " not taken" << "\n" << std::endl;
                }
                return;
            }
        }
        std::cout << "Table " << tableNumber << " not found" << "\n" << std::endl;
    }
    
    void printTableStatus() const {
        std::cout << "Tables and their status:" << std::endl;
        for (const Table& table : tables) {
            std::cout << "Table " << table.getNumber() << ": ";
            if (table.isReserved()) {
                std::cout << "is taken by " << table.getReservedBy();
                if (table.getNumber() == coffeeOrderTableNumber) {
                    std::cout << " - ordered coffee";
                }
            }
            else {
                std::cout << "free";
            }
            std::cout << std::endl;
        }
    }

    void getCoffee(int tableNumber) {
        orderCoffee(tableNumber);
        for (Table& table : tables) {
            if (table.getNumber() == tableNumber) {
                if (table.isReserved()) {

                    std::cout << "Coffee ordered for Table " << tableNumber << "\n" << std::endl;
                }
                else {
                    std::cout << "Table " << tableNumber << " not taken, can't order coffee" << "\n" << std::endl;
                }
                return;
            }
        }
        std::cout << "Table " << tableNumber << " not found" << "\n" << std::endl;
    }

    void orderCoffee(int tableNumber) {
        coffeeOrderTableNumber = tableNumber;
    }


    void printPayment(int tableNumber) {
        if (tableNumber == coffeeOrderTableNumber) {
            std::cout << "Payment for coffee: $60.00" << std::endl;
        }
        else {
            std::cout << "No coffee order for table " << tableNumber << std::endl;
        }
    }

private:
    std::vector<Table> tables;
    int coffeeOrderTableNumber;
};

int main() {
    // manager
    Manager manager;

    // add tables
    //manager.addTable(Table(1));

    // add tables
    for (int i = 1; i <= 10; ++i) {
        manager.addTable(Table(i));
    }

    std::string input;

    while (true) {
        std::cout << "Choose option\n 1 - Take table \n 2 - free table \n 3 - info about tables \n 4 - Coffee \n 5 - print Payment \n";
        std::getline(std::cin, input);

        if (input == "exit") {
            break;
        }

        std::cout << "-----------------------------" << std::endl;

        std::istringstream is(input);
        std::string command;
        int tableId;
        std::string visitorName;

        is >> command;

        if (command == "1") {
            is >> tableId;
            is >> visitorName;
            manager.reserveTable(tableId, visitorName);
            manager.printTableStatus();
            std::cout << "-----------------------------" << std::endl;

        }
        else if (command == "2") {
            is >> tableId;
            manager.freeTable(tableId);
            manager.printTableStatus();
            manager.printPayment(1);
            std::cout << "-----------------------------" << std::endl;

        }
        else if (command == "3") {
            std::cout << "info about tables: " << std::endl;
            manager.printTableStatus();
            std::cout << "-----------------------------" << std::endl;
        }
        else if (input == "4") {
            int tableNumber;
            std::cin >> tableNumber;
            manager.getCoffee(tableNumber);
        }
        else if (command == "5") {
            int tableNumber;
            std::cout << "Enter table number for payment: ";
            std::cin >> tableNumber;
            manager.printPayment(tableNumber);
        }
    }

    std::cout << "-----------------------------" << std::endl;

    return 0;
}