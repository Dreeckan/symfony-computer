import Choices from "choices.js";
import $ from 'jquery';

$(function () {
    $('[data-choices]').each(function () {
        const $element = $(this);

        new Choices($element[0], {
            silent: false,
            removeItemButton: true,
            duplicateItemsAllowed: false,
            loadingText: 'Chargement...',
            noResultsText: 'Pas de résultats',
            noChoicesText: 'Pas de résultats',
            itemSelectText: 'Cliquer pour sélectionner',
            searchResultLimit: 50
        });
    });
});