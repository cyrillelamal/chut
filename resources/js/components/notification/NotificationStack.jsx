import React from "react";
import {ToastContainer} from "react-bootstrap";
import Notification from "./Notification";


export default class NotificationStack extends React.Component {
    removeNotification = (key) => {
        this.props.setNotifications(this.notifications.filter(n => n.key !== key));
    }

    notification = (n) => <Notification key={n.key} {...n} uid={n.key} remove={this.removeNotification}/>;

    render() {
        return (
            <ToastContainer position="bottom-end" className="p-2 h-75 overflow-auto d-flex flex-column-reverse">
                {this.notifications.map(this.notification)}
            </ToastContainer>
        );
    }

    get notifications() {
        return this.props.notifications ?? [];
    }
}
