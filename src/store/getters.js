export const getters = {
    GET_GENERAL_SETTINGS: ( state ) => {
        let settings = {
            countRows: state.countRows,
            humanReadable: state.humanReadable,
            email: state.email
        }
        return settings;
    },

    GET_LOADING_TEXT: ( state ) => {
        return state.loadingText;
    },

    GET_TABLE_HEADERS: ( state ) => {
        return state.tableHeaders;
    },

    GET_TABLE_ROWS: ( state ) => {
        return state.tableRows;
    },

    GET_GRAPH_DATA: ( state ) => {
        return state.graphData;
    },
}