#include <iostream>
#include <ctime>
#include <cstdlib>
#include <vector>
#include <string>

// Менеджеры кафе
std::vector<std::string> managers = { "Менеджер 1", "Менеджер 2", "Менеджер 3" };

// Состояние стола (свободен или занят)
enum TableState {
    Free,
    Occupied
};

// Состояние стола
struct Table {
    int tableID;
    TableState state;
    std::string managerName;
    int guestCount;
    int timeRemaining;
};

// Проверка стола на свободность
bool isTableFree(const Table& table) {
    return table.state == Free;
}

// Генерация рандомного целого числа в диапазоне [min, max]
int generateRandomInt(int min, int max) {
    return min + rand() % (max - min + 1);
}

// Имитация прихода пользователей в кафе
void simulateCustomerArrival(std::vector<Table>& tables, int hour) {
    for (size_t i = 0; i < tables.size(); ++i) {
        if (isTableFree(tables[i])) {
            int guestCount = generateRandomInt(1, 8);
            int timeToSpend = guestCount * 15;
            tables[i].state = Occupied;
            tables[i].guestCount = guestCount;
            tables[i].timeRemaining = timeToSpend;

            std::cout << "Компания из " << guestCount << " человек заказала стол " << tables[i].tableID << " в зале " << tables[i].managerName << ". Время работы: " << timeToSpend << " минут." << std::endl;
        }
    }
}

// Имитация ухода пользователей из кафе
void simulateCustomerDeparture(std::vector<Table>& tables) {
    for (size_t i = 0; i < tables.size(); ++i) {
        if (!isTableFree(tables[i])) {
            if (tables[i].timeRemaining > 0) {
                tables[i].timeRemaining -= 1;
            }
            else {
                tables[i].state = Free;
                tables[i].guestCount = 0;
                tables[i].timeRemaining = 0;
                std::cout << "Компания из " << tables[i].guestCount << " человек покинула стол " << tables[i].tableID << " в зале " << tables[i].managerName << "." << std::endl;
            }
        }
    }
}

int main() {
    srand(time(0));

    // Инициализация столов кафе
    std::vector<Table> tables;
    for (int i = 0; i < 9; ++i) {
        Table table;
        table.tableID = i + 1;
        table.state = Free;
        table.managerName = managers[i / 3];
        table.guestCount = 0;
        table.timeRemaining = 0;
        tables.push_back(table);
    }

    // Запуск симуляции кафе
    for (int hour = 9; hour <= 23; ++hour) {
        simulateCustomerArrival(tables, hour);
        simulateCustomerDeparture(tables);
    }

    return 0;
}