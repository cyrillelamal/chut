import React, {Suspense} from "react";
import {Route, Routes} from "react-router-dom";


import {discoverChannels} from "../services/echo";
import {getCsrfToken, getUser} from "../services/security";


import {UserContext} from "./security/UserContext";
import {NotificationContext} from "./notification/NotificationContext";
import LatestNotificationContext from "./notification/LatestNotificationContext";


import Loading from "./Loading";

import NotificationStack from "./notification/NotificationStack";
import Notification from "../models/Notification";

const Index = React.lazy(() => import("./Index"));
const NotFound = React.lazy(() => import("./NotFound"));

const Register = React.lazy(() => import("./security/Register"));
const Login = React.lazy(() => import("./security/Login"));
const Logout = React.lazy(() => import("./security/Logout"));

const CommunicationCenter = React.lazy(() => import("./communication-center/CommunicationCenter"));
const Conversation = React.lazy(() => import("./conversation/Conversation"));


export default class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            user: getUser(),
            latest_notification: null,
            notifications: [],
        }
    }

    async componentDidMount() {
        await getCsrfToken();

        if (this.user) {
            discoverChannels().then(({data}) => this.subscribe(data));
        }
    }

    subscribe = (channels) => {
        for (const channel of channels) {
            Echo.private(channel).listen('MessageSent', (e) => {
                const notification = Notification.createFromMessage(e.data);
                this.setState(state => ({
                    notifications: [...state.notifications, notification],
                    latest_notification: notification,
                }));
            })
        }
    }

    setUser = (user) => {
        this.setState({user});
    }

    setNotifications = (notifications) => {
        this.setState({notifications});
    }

    render() {
        return (
            <>
                <UserContext.Provider value={this.userContext}>
                    <NotificationContext.Provider value={this.notifications}>
                        <LatestNotificationContext.Provider value={this.latestNotification}>
                            <Suspense fallback={<Loading/>}>
                                <Routes>
                                    <Route path="/" element={<Index/>}/>
                                    <Route path="/register" element={<Register/>}/>
                                    <Route path="/login" element={<Login/>}/>
                                    <Route path="/logout" element={<Logout/>}/>
                                    <Route path="/cc" element={<CommunicationCenter/>}/>
                                    <Route path="/conversations/:id" element={<Conversation/>}/>
                                    <Route path="*" element={<NotFound/>}/>
                                </Routes>
                            </Suspense>

                            <NotificationStack notifications={this.notifications}
                                               setNotifications={this.setNotifications}/>
                        </LatestNotificationContext.Provider>
                    </NotificationContext.Provider>
                </UserContext.Provider>
            </>
        );
    }

    get user() {
        return this.state.user;
    }

    get notifications() {
        return this.state.notifications;
    }

    get latestNotification() {
        return this.state.latest_notification;
    }

    get userContext() {
        return {
            user: this.user,
            setUser: this.setUser,
        }
    }
}
