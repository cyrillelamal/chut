import React from "react";
import Authenticated from "../security/Authenticated";

export default class ConversationList extends React.Component {
    render() {
        return (
            <Authenticated>
                <div>
                    list con
                </div>
            </Authenticated>
        );
    }
}
