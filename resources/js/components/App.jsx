import React from "react";
import {Route, Routes} from "react-router-dom";
import NotFound from "./NotFound";
import {getCsrfToken, getUser} from "../services/security";
import Register from "./security/Register";
import Login from "./security/Login";
import {UserContext} from "./security/UserContext";
import Logout from "./security/Logout";
import Index from "./Index";
import CommunicationCenter from "./communication-center/CommunicationCenter";
import Conversation from "./conversation/Conversation";


export default class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            user: getUser(),
        }
    }

    async componentDidMount() {
        await getCsrfToken();
    }

    render() {
        return (
            <>
                <UserContext.Provider value={{user: this.state.user, setUser: this.setUser}}>
                    <Routes>
                        <Route path="/" element={<Index/>}/>
                        <Route path="/register" element={<Register/>}/>
                        <Route path="/login" element={<Login/>}/>
                        <Route path="/logout" element={<Logout/>}/>
                        <Route path="/cc" element={<CommunicationCenter/>}/>
                        <Route path="/conversations/:id" element={<Conversation/>}/>
                        <Route path="*" element={<NotFound/>}/>
                    </Routes>
                </UserContext.Provider>
            </>
        );
    }

    setUser = (user) => this.setState({user});
}
