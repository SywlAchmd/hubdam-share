import { Tab, TabGroup, TabList } from "@headlessui/react";
import React from "react";

type TabOption = {
  label: string;
  value: string;
};

type FilterTabsProps = {
  tabs: TabOption[];
  selectedFilter: string;
  onFilterChange: (value: string) => void;
};

export default function FilterTabs({ tabs, selectedFilter, onFilterChange }: FilterTabsProps) {
  return (
    <TabGroup
      selectedIndex={tabs.findIndex((tab) => tab.value === selectedFilter)}
      onChange={(index) => onFilterChange(tabs[index].value)}
    >
      <TabList className="flex space-x-1 rounded bg-white p-2">
        {tabs.map((tab) => (
          <Tab
            key={tab.value}
            className={({ selected }) =>
              `rounded px-4 py-2 text-sm font-medium focus:outline-none focus-visible:ring-0 ${
                selected
                  ? "bg-forest-green/80 text-white"
                  : "text-gray-400 data-[hover]:bg-forest-green/15 data-[hover]:text-gray-500"
              }`
            }
          >
            {tab.label}
          </Tab>
        ))}
      </TabList>
    </TabGroup>
  );
}
