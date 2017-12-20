//js树形查找

function getName(arr, id) {

        var num = arr.length;

        for (var i = 0; i < num; i++) {
            if (arr[i].id == id) {
                return arr[i].name
            } else {
                if (arr[i].children) {
                    return getName(arr[i].children, id)
                }
            }
        }
        return ''
    }

    var trees = [
        {
            id: 1,
            name: 'a',
            children: [
                {
                    id: 4,
                    name: 'b'
                },
                {
                    id: 5,
                    name: 'd'
                }

            ]
        },
        {
            id: 2,
            name: 'b',
            children: []
        },
        {
            id: 3,
            name: 'd',
            children: []
        }
    ]

    console.log(getName(trees, 5))
