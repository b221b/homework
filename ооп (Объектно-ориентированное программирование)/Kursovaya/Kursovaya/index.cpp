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
                std::cout << "taken by " << table.getReservedBy();
            }
            else {
                std::cout << "free";
            }
            std::cout << std::endl;
        }
    }

private:
    std::vector<Table> tables;
};

int main() {
    // manager
    Manager manager;

    // add tables
    manager.addTable(Table(1));
    manager.addTable(Table(2));
    manager.addTable(Table(3));
    manager.addTable(Table(4));
    manager.addTable(Table(5));
    manager.addTable(Table(6));
    manager.addTable(Table(7));
    manager.addTable(Table(8));
    manager.addTable(Table(9));

    std::string input;

    while (true) {
        std::cout << "Choose option\n 1 - Take table \n 2 - free table \n 3 - info about tables \n 4 - exit \n";
        std::getline(std::cin, input);

        if (input == "quit") {
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
            std::cout << "-----------------------------" << std::endl;

        }
        else if (command == "3") {
            std::cout << "info about tables: " << std::endl;
            manager.printTableStatus();
            std::cout << "-----------------------------" << std::endl;
        }
        else if (command == "4") {
            std::cout << "exit" << std::endl;
            exit(0);
        }
        else {
            std::cout << "unknown command" << std::endl;
            std::cout << "-----------------------------" << std::endl;

        }
    }

    std::cout << "-----------------------------" << std::endl;

    return 0;
}