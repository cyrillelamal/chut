import React from "react";
import {Routes, Route} from "react-router-dom";

const Foo = () => {
    return <h1>foo</h1>
}

const Bar = () => {
    return <h2>bar</h2>
}

export class App extends React.Component {
    render() {
        return (
            <div>
                <h1>Salut !</h1>
                <Routes>
                    <Route path={'/foo'} element={<Foo/>}/>
                    <Route path={'/bar'} element={<Bar/>}/>
                </Routes>
            </div>
        );
    }
}
