#include <iostream>
#include <vector>
#include <string>

class Table {
private:
    int number;

protected:

public:
    std::string visitorName;

    Table(int number) : number(number), visitorName("") {}

    int getNumber() const {
        return number;
    }

    bool isReserved() const {
        return visitorName != "";
    }

    void reserve(const std::string& visitorName) {
        this->visitorName = visitorName;
    }

    void free() {
        visitorName = "";
    }
};

class Manager {
private:
    std::vector<Table> tables;
    int coffeeOrderTableNumber;

public:
    Manager() : coffeeOrderTableNumber(0) {}

    void addTable(const Table& table) {
        tables.push_back(table);
    }

    void reserveTable(int tableNumber, const std::string& visitorName) {
        for (size_t i = 0; i < tables.size(); ++i) {
            if (tables[i].getNumber() == tableNumber) {
                tables[i].reserve(visitorName);
                return;
            }
        }
        std::cout << "Table " << tableNumber << " not found" << "\n" << std::endl;
    }

    void freeTable(int tableNumber) {
        for (size_t i = 0; i < tables.size(); ++i) {
            if (tables[i].getNumber() == tableNumber) {
                tables[i].free();
                return;
            }
        }
        std::cout << "Table " << tableNumber << " not found" << "\n" << std::endl;
    }

    void printTableStatus() const {
        for (size_t i = 0; i < tables.size(); ++i) {
            std::cout << "Table " << tables[i].getNumber();
            if (tables[i].isReserved()) {
                std::cout << " is reserved for " << tables[i].visitorName;
            }
            else {
                std::cout << " is not reserved";
            }
            std::cout << "\n";
        }
    }

    void getCoffee(int tableNumber) {
        for (size_t i = 0; i < tables.size(); ++i) {
            if (tables[i].getNumber() == tableNumber) {
                if (tables[i].isReserved()) {
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
        for (size_t i = 0; i < tables.size(); ++i) {
            if (tables[i].isReserved()) {
                totalIncome += 60; // $60 per coffee
            }
        }
        return totalIncome;
    }

    void resetCoffeeOrder(int tableNumber) {
        for (size_t i = 0; i < tables.size(); ++i) {
            if (tables[i].getNumber() == tableNumber) {
                tables[i].free();
                return;
            }
        }
    }

};

int main() {
    // manager
    Manager manager;

    // add tables
    for (int i = 1; i <= 10; ++i) {
        manager.addTable(Table(i));
    }

    // reserve tables
    manager.reserveTable(1, "John");
    manager.reserveTable(2, "Mike");

    // print table status
    manager.printTableStatus();

    // order coffee
    manager.getCoffee(1);
    manager.getCoffee(3);

    // print payment
    manager.printPayment(1);
    manager.printPayment(3);

    // calculate total income
    double totalIncome = manager.calculateTotalIncome();
    std::cout << "Total income: $" << totalIncome << std::endl;

    // reset coffee order
    manager.resetCoffeeOrder(1);

    // print payment after reset
    manager.printPayment(1);

    return 0;
}