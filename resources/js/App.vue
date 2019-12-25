<template>
    <div
        id="demo"
        :class="[{'collapsed' : collapsed}]"
    >
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">
                Putra Future Classroom Dashboard
            </a>
        </nav>
        <div class="demo">
            <div class="container-fluid">

                <router-view></router-view>

            </div>

            <sidebar-menu
                :menu="menu"
                :collapsed="collapsed"
                :show-one-child="true"
                @toggle-collapse="onToggleCollapse"
                @item-click="onItemClick"
            />
        </div>
    </div>

</template>

<script>
    import SidebarMenu from './components/SidebarMenu.vue';

    const separator = {
        template: '<hr style="border-color: rgba(0, 0, 0, 0.2); margin: 20px;">'
    }
    export default {
        components: {
            'sidebar-menu': SidebarMenu,
        },

        name: 'App',
        data() {
            return {
                menu: [
                    {
                        header: true,
                        title: 'Getting Started',
                        hiddenOnCollapse: true
                    },
                    {
                        href: '/',
                        title: 'Home',
                        icon: 'fa fa-home'

                    },
                    {
                        href: '/dashboard',
                        title: 'Dashboard',
                        icon: 'fa fa-chart-bar'

                    },
                    // {
                    //     href: '/register',
                    //     title: 'Attendance',
                    //     icon: 'fa fa-id-card'
                    // },
                    {
                        href: '/attendance',
                        title: 'Attendance',
                        icon: 'fa fa-id-card',
                        //
                        // child: [
                        //         {
                        //             href: '/attend/report',
                        //             title: 'Attendance Report',
                        //             icon: 'fa fa-file-alt'
                        //         },
                        //
                        //     ]
                    },
                    {
                        href: '/emotion',
                        title: 'Facial Expression',
                        icon: 'fa fa-smile'
                    },
                    {
                        href: '/classemo',
                        title: 'Class Emotion',
                        icon: 'fa fa-smile'
                    },
                    {
                        component: separator
                    },
                    {
                        header: true,
                        title: 'Classroom Environment',
                        hiddenOnCollapse: true
                    },
                    {
                        href: '/lights',
                        title: 'Lights',
                        icon: 'fa fa-lightbulb'
                    },
                    // {
                    //     href: '/temperature',
                    //     title: 'Temperature',
                    //     icon: 'fa fa-thermometer-half '
                    // },

                    // {
                    //     href: '/page',
                    //     title: 'Dropdown Page',
                    //     icon: 'fa fa-list-ul',
                    //     badge: {
                    //         text: 'new',
                    //         class: 'vsm--badge_default'
                    //     },
                    //     child: [
                    //         {
                    //             href: '/page/sub-page-1',
                    //             title: 'Sub Page 01',
                    //             icon: 'fa fa-file-alt'
                    //         },
                    //
                    //     ]
                    // },
                    // {
                    //     title: 'Multiple Level',
                    //     icon: 'fa fa-list-alt',
                    //     child: [
                    //         {
                    //             title: 'page'
                    //         },
                    //         {
                    //             title: 'Level 2 ',
                    //             child: [
                    //                 {
                    //                     title: 'page'
                    //                 },
                    //                 {
                    //                     title: 'Page'
                    //                 }
                    //             ]
                    //         },
                    //
                    //
                    //     ]
                    // }
                ],
                collapsed: false,
                // themes: [
                //     {
                //         name: 'Default theme',
                //         input: ''
                //     },
                //     {
                //         name: 'White theme',
                //         input: 'white-theme'
                //     }
                // ],
                // selectedTheme: 'white-theme'
            }
        },
        methods: {
            onToggleCollapse(collapsed) {
                //      console.log(collapsed)
                this.collapsed = collapsed
            },
            onItemClick(event, item) {
                //     console.log('onItemClick')
                // console.log(event)
                // console.log(item)
            }
        }
    }
</script>

<style lang="scss">
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600');

    body,
    html {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 19px;
        /*background-color: #f2f4f7;*/
        color: #262626;
    }

    #demo {
        padding-left: 350px;
    }

    #demo.collapsed {
        padding-left: 50px;
    }

    .demo {
        padding: 50px;
    }

    .container {
        max-width: 900px;
    }

    pre {
        font-family: Consolas, monospace;
        color: #000;
        background: #fff;
        border-radius: 2px;
        padding: 15px;
        line-height: 1.5;
        overflow: auto;
    }
</style>
