var charSex = {
    '0': 'Sem restrição',
    '1': 'Masculino',
    '2': 'Feminino',
    '3': 'Ambos'
};

var classNames = {
    '0': 'Todas',
    '32': 'Guerreiro',
    '64': 'Cavaleiro',
    '97': 'Espadachim',
    '128': 'Bruxo',
    '256': 'Feiticeiro',
    '386': 'Mago',
    '512': 'Ranger',
    '1024': 'Beastmaster',
    '1540': 'Arqueiro',
    '2048': 'Mercenario',
    '4096': 'Arruaceiro',
    '6152': 'Gatuno',
    '8192': 'Sarcedote',
    '16384': 'Monge',
    '24592': 'Noviço'
};

var itemsCats = {
    '0':'Todas',
    '1':'Weapon',
    '2':'Sword',
    '3':'Great Sword',
    '4':'Aura Sword',
    '5':'Staff',
    '6':'Rod',
    '7':'Rune Staff',
    '8':'Bow',
    '9':'Quiver',
    '10':'Hunter Bow',
    '11':'Spear',
    '12':'Dagger',
    '13':'Claw',
    '14':'Dual Dagger',
    '15':'Mace',
    '16':'Holy Mace',
    '17':'Knuckle',
    '18':'Stick',
    '19':'Scythe',
    '20':'Handle',
    '21':'Doll',
    '22':'Shield',
    '23':'바이블',
    '24':'Armor',
    '25':'Cloth',
    '26':'Cloth Top',
    '27':'Cloth Bottom',
    '28':'Cloth Helm',
    '29':'Cloth Gloves',
    '30':'Cloth Shoes',
    '31':'Light Armor',
    '32':'Light Armor Top',
    '33':'Light Armor Bottom',
    '34':'Light Armor Helm',
    '35':'Light Armor Gloves',
    '36':'Light Armor Shoes',
    '37':'Heavy Armor',
    '38':'Heavy Armor Top',
    '39':'Heavy Armor Bottom',
    '40':'Heavy Armor Helm',
    '41':'Heavy Armor Gloves',
    '42':'Heavy Armor Shoes',
    '43':'Accessory',
    '44':'Necklace',
    '45':'Earrings',
    '46':'Ring',
    '47':'Ornament',
    '48':'Decoration',
    '49':'Deco. Clothes',
    '50':'Deco. Acc.',
    '51':'Card',
    '52':'Ingredient',
    '53':'Consumables',
    '54':'Potion',
    '55':'Recovery Potion',
    '56':'Reinforced Potion',
    '57':'Boost Potion',
    '58':'Food',
    '59':'Recovery Food',
    '60':'Reinforced Food',
    '61':'Socket',
    '62':'Socket Drill',
    '63':'Socket Stone',
    '64':'Scroll',
    '65':'Reinforced Buff',
    '66':'Battle Assist',
    '67':'Others',
    '68':'Job Equipment',
    '69':'Design',
    '70':'Blacksmith',
    '71':'Artisan',
    '72':'Alchemist',
    '73':'Chef',
    '74':'Reinforcement',
    '75':'Card Synthesis Stone',
    '76':'Smelting stone',
    '77':'Others'
};

var row_total = 0;
var sel_class = 0;
var sel_categories = 0;
var act_start = 0;
var itens_page = 5;

function updateVars(new_start) {
    sel_class = $("#selclass").find('option:selected').val();
    sel_categories = $("#selcategory").find('option:selected').val();
    act_start = new_start;
}

function itemsPage() {
    var itemPage =  $('<li/>').append($('<li/>', {'id': 'filteroptions'}));
    itemPage.find('#filteroptions').append("<div id='itemlistoptions'></div>");
    itemPage.find("#filteroptions #itemlistoptions").append("<form id='itemsform' action='javascript:void(0);' method='get'></form>");
    itemPage.find("#filteroptions #itemlistoptions #itemsform").append("<span class='classtext'>Classe:</span><select id='selclass' class='classes'>");
    itemPage.find("#filteroptions #itemlistoptions #itemsform").append("<span class='classtext'>Categoria:</span><select id='selcategory' class='categories'>");
    itemPage.find("#filteroptions #itemlistoptions #itemsform").append("<input class='button' type='submit' onclick='window.updateVars(0);window.getItems();' value='Filtrar'>");

    $.each(classNames, function (index, value) {
        var selected = '';
        if(index == sel_class) {
            selected = ' selected="true"';
        }
        itemPage.find("#filteroptions #itemlistoptions #itemsform #selclass").append("<option value='" + index + "'" + selected + ">" + value + "</option>");
    });

    $.each(itemsCats, function (key, val) {
        var selected = '';
        if(key == sel_categories) {
            selected = ' selected="true"';
        }
        itemPage.find("#selcategory").append("<option value='" + key + "'" + selected + ">" + val + "</option>");
    });

    //$('#content').append('<br style="clear: both;" />');
    return itemPage.html();
}

function getItems() {
    $.getJSON('json.php?get=item&data=[{"start":"' + act_start + '","count":"' + itens_page + '","classe":"' + sel_class + '","category":"' + sel_categories + '"}]', function (data) {
        var items = [];
        items.push(itemsPage());
        $.each(data, function (key, val) {
            if (key == 'total') {
                $.each(val, function (kk, vv) {
                    row_total = vv['total'];
                });
            }
            if (key == 'data') {
                $.each(val, function (kk, vv) {
                    if (vv['ID'] !== null) {
                        var line = $('<li/>').append($('<li/>', {'id': 'item-' + kk}));
                        line.find('#item-' + kk).append($('<img/>', {'class': 'icon'}), $('<div/>', {'class': 'info'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'name'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'reqjob'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'reqlvl'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'desc'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'category'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'itemlvl'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'reqsex'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'price'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'candrop'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'candeposit'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'candestruct'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'cansell'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'cantrade'}));
                        line.find('#item-' + kk + ' .info').append($('<span/>', {'class': 'cancompose'}));
                        line.find('#item-' + kk + ' .info').append('<a href="javascript:void(0);" class="button">Ver Mais</a>');
                        $.each(vv, function (k, v) {
                            switch (k) {
                                case 'Name':
                                    line.find('.name').html(v);
                                    break;
                                case 'Description':
                                    line.find('.desc').html(v);
                                    break;
                                case 'Category':
                                    line.find('.category').html('<b>Categoria:</b> ' + v);
                                    break;
                                case 'Grade':
                                    switch (v) {
                                        case '1':
                                            line.find('.name').addClass('normal');
                                            break;
                                        case '2':
                                            line.find('.name').addClass('green');
                                            break;
                                        case '3':
                                            line.find('.name').addClass('blue');
                                            break;
                                        case '4':
                                            line.find('.name').addClass('purple');
                                            break;
                                        default:
                                            line.find('.name').addClass('normal');
                                            break;
                                    }
                                    break;
                                case 'Icon':
                                    line.find('.icon').attr('src', v);
                                    break;
                                case 'Require_Job':
                                    line.find('.reqjob').html('<b>Classe:</b> ' + getiReqJob(v));
                                    break;
                                case 'Item_Lv':
                                    line.find('.itemlvl').html('<b>Item Lvl:</b> ' + v);
                                    break;
                                case 'Require_Level':
                                    line.find('.reqlvl').html('<b>Lvl Requerido:</b> ' + getiLvl(v));
                                    break;
                                case 'Require_Sex':
                                    line.find('.reqsex').html('<b>Sexo:</b> ' + getiReqSex(v));
                                    break;
                                case 'Price_Buy':
                                    line.find('.price').html('<b>Preço:</b> ' + getiPrice(v));
                                    break;
                                case 'Is_Drop':
                                    line.find('.candrop').html('<b>Pode dropar:</b> ' + (v ? 'Sim' : 'Não'));
                                    break;
                                case 'Is_Deposit':
                                    line.find('.candeposit').html('<b>Pode depositar:</b> ' + (v ? 'Sim' : 'Não'));
                                    break;
                                case 'Is_Destruct':
                                    line.find('.candestruct').html('<b>Pode destruir:</b> ' + (v ? 'Sim' : 'Não'));
                                    break;
                                case 'Is_Sell':
                                    line.find('.cansell').html('<b>Pode vender:</b> ' + (v ? 'Sim' : 'Não'));
                                    break;
                                case 'Is_Trade':
                                    line.find('.cantrade').html('<b>Pode trocar:</b> ' + (v ? 'Sim' : 'Não'));
                                    break;
                                case 'Is_Compose':
                                    line.find('.cancompose').html('<b>Pode compor:</b> ' + (v ? 'Sim' : 'Não'));
                                    break;
                            }
                        });
                        items.push(line.html());
                    }
                });
            }
        });
        $('#content').html('');
        $('<ul/>', {html: items.join(''), 'id': 'itemlist'}).appendTo('#content');
        $('#content').append('<br style="clear: both;" />');
        // Pagination
        var pages = $('<div/>').append($('<div/>', {'id': 'pagination'}));
        pages.find('#pagination').append($('<div/>', {'id': 'back'}));
        pages.find('#pagination').append($('<div/>', {'id': 'pages'}));
        pages.find('#pagination').append($('<div/>', {'id': 'next'}));

        // Pages
        var apage =  Math.round((itens_page + act_start) / itens_page);
        var i = 0;
        var pagecount = row_total / itens_page;
        pagecount = Math.round(pagecount);
        if (apage !== 1) {
            pages.find('#pages').append("<a id=\"first_page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.updateVars(0);window.getItems();\">1</a>");
            if ((apage - 4) > 1) {
                pages.find('#pages').append("<span id=\"page\" class=\"button\">. . .</span>");
            }
        }
        if (apage > 1) {
            for (i = (apage - 4); i < apage; i++) {
                if (i > 1) {
                    pages.find('#pages').append("<a id=\"page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.updateVars(" + ((i * 5) - 5) + ");window.getItems();\">" + i + "</a>");
                }
            }
        }
        pages.find('#pages').append("<span id=\"page_actual\" class=\"button\">" + apage + "</span>");
        if (apage < pagecount) {
            for (i = (apage + 1); i < (apage + 5); i++) {
                if (i < pagecount) {
                    pages.find('#pages').append("<a id=\"page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.updateVars(" + ((i * 5) - 5) + ");window.getItems();\">" + i + "</a>");
                }
            }
        }
        if (apage !== pagecount) {
            if ((apage + 4) < pagecount) {
                pages.find('#pages').append("<span id=\"page\" class=\"button\">. . .</span>");
            }
            pages.find('#pages').append("<a id=\"last_page\" href=\"javascript:void(0);\" class=\"button\" onClick=\"window.updateVars(" + (row_total - itens_page) + ");window.getItems();\">" + pagecount + "</a>");
        }

        if (act_start > 0) {
            pages.find('#back').append('<a class="button" href="javascript:void(0);" onClick="window.updateVars(' + (act_start - itens_page) + ');window.getItems();"><< Anterior</a>');
        }
        if (row_total > (act_start + itens_page)) {
            pages.find('#next').append('<a class="button" href="javascript:void(0);" onClick="window.updateVars(' + (act_start + itens_page) + ');window.getItems();">Próxima >></a>');
        }
        $('#content').append(pages.html());
        $('#content').append('<br style="clear: both;" />');
    });
}

function getiPrice(id) {
    return ((id > 999) ? id.substr(0, id.length - 3) + 'z ' : '') + ((id.substr(id.length - 3) !== 0) ? id.substr(id.length - 3) + 'r' : '0r');
}

function getiReqSex(id) {
    var ret = id;
    $.each(charSex, function (i, v) {
        if (id == i) {
            ret = v;
        }
    });
    return ret;
}

function getiReqJob(id) {
    var ret = id;
    $.each(classNames, function (i, v) {
        if (id == i) {
            ret = v;
        }
    });
    return ret;
}

function getiLvl(lv) {
    var ret = lv;
    if (lv == 0) {
        ret = 'Sem restrição';
    }
    return ret;
}