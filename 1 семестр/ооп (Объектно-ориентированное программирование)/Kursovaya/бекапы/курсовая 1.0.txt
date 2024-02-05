#include <iostream>
#include <vector>
#include <string>
#include <sstream>

class Table {
private:
    int number;
    bool reserved;
    std::string reservedBy;

public:
    Table(int number) : number(number), reserved(false), reservedBy("") {
    }

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
};

class Manager {
private:
    std::vector<Table> tables;
    int coffeeOrderTableNumber;
    std::vector<int> coffeeOrders;

public:
    void addTable(const Table& table) {
        tables.push_back(table);
        coffeeOrders.push_back(0);
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

    void printTableStatus() {
        for (size_t i = 0; i < tables.size(); ++i) {
            std::cout << "Table " << tables[i].getNumber();
            if (tables[i].isReserved()) {
                std::cout << " is taken by " << tables[i].getReservedBy();
                if (coffeeOrders[i] == tables[i].getNumber()) {
                    std::cout << " - ordered coffee, payment for coffee: $60.00";
                }
            }
            else {
                std::cout << "free";
            }
            std::cout << std::endl;

        }
        std::cout << "Total income from coffee orders: $" << calculateTotalIncome() << "\n";
    }

    void getCoffee(int tableNumber) {
        orderCoffee(tableNumber);
        for (size_t i = 0; i < tables.size(); ++i) {
            if (tables[i].getNumber() == tableNumber) {
                if (tables[i].isReserved()) {
                    coffeeOrders[i] = tableNumber;
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

    double calculateTotalIncome() {
        double totalIncome = 0;
        for (size_t i = 0; i < coffeeOrders.size(); ++i) {
            if (coffeeOrders[i] != 0) {
                totalIncome += 60; // $60 per coffee
            }
        }
        return totalIncome;
    }

    void resetCoffeeOrder(int tableNumber) {
        for (size_t i = 0; i < coffeeOrders.size(); ++i) {
            if (tables[i].getNumber() == tableNumber) {
                coffeeOrders[i] = 0;
                return;
            }
        }
    }


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
            manager.resetCoffeeOrder(tableId);
            manager.printTableStatus();
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