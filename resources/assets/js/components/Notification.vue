<template>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                <span class="glyphicon glyphicon-globe"></span> Notification <span class="badge">{{notifications.length}}</span> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" style=" min-width: 25em;
        background-color: #3c8dbc;">
            <li v-for = " notification in notifications ">
            <a href="#" style="color:white; padding:1em"> {{ notification.data.reservation.doctor.user.name   }} {{ notification.data.reservation.response  }} reservation for {{notification.data.reservation.patient.name   }}</a>
            </li>


        </ul>
    </li>
</template>

<script>
    export default {
       props: ['notifications']
    }
</script>

