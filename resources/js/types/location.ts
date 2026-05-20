export type CityOption = {
    id: number;
    name: string;
    state?: string;
};

export type StateOption = {
    id: number;
    name: string;
    abbreviation: string;
    cities: CityOption[];
};
