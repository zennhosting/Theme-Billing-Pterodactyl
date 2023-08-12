import React, { useEffect, useState, useMemo } from 'react';
import tw from 'twin.macro';
import { bytesToString, ip, mbToBytes } from '@/lib/formatters';
import { ServerContext } from '@/state/server';
import CopyOnClick from '@/components/elements/CopyOnClick';
import { SocketEvent, SocketRequest } from '@/components/server/events';
import UptimeDuration from '@/components/server/UptimeDuration';
import RamGraph from '@/components/server/console/graphs/RamGraph';
import CPUGraph from '@/components/server/console/graphs/CPUGraph';
import styled,{ css }  from 'styled-components/macro'; 
import useWebsocketEvent from '@/plugins/useWebsocketEvent';
import * as Icon from 'react-feather';
import { Connecting, Installing, Transferring } from '@/lang';

const DetailsItem = styled.div`
    position:relative;
    background-color:var(--secondary);
    border-radius:15px;
    height:200px;
    overflow:hidden;
    z-index:10;
    margin-bottom:20px;

    &.long{
        max-height:100%;
        height:auto;
    }

    & canvas{
        z-index:-1;
        position:absolute;
        bottom:-10px;
        max-height:120px;
        width:calc(100% + 11px) !important;
        margin-left:-10px;
        left:0;
    }
    & > .discription,
    & > .mainCard{
        padding:20px 25px;
    }
    & > .discription > p{
        z-index:10;
        font-size:calc(2em + 50%);
        font-weight:bold;
        letter-spacing:-1px;
    }
    & > .mainCard > p.header{
        z-index:10;
        font-size:2em;
        font-weight:bold;
        letter-spacing:-1px;
        margin-bottom:20px;
    }
    .status{
        position:absolute;
        width:100%;
        height:50%;
        bottom:0;
        opacity:.2;
        z-index:-1;
    }
`;
const DISKGraph = styled.div`
    position:absolute;
    width:100%;
    height:70px;
    bottom:0;
    border-top:2px solid #3B6CDE;
    background-color:rgb(59, 108, 222, .5);
`;

type Stats = Record<'memory' | 'cpu' | 'disk' | 'uptime' | 'rx' | 'tx', number>;

function statusToColor (status: string | null, installing: boolean) {
    if (installing) {
        status = '';
    }

    switch (status) {
        case 'offline':
            return css`&{background-image:linear-gradient(transparent, #f54242);`;
        case 'running':
            return css`&{background-image:linear-gradient(transparent, #42f560);`;
        default:
            return css`&{background-image:linear-gradient(transparent, #fff345);`;
    }
}

const SideGraph =  () => {


    const [ stats, setStats ] = useState<Stats>({ memory: 0, cpu: 0, disk: 0, uptime: 0, tx: 0, rx: 0 });

    const status = ServerContext.useStoreState(state => state.status.value);
    const connected = ServerContext.useStoreState(state => state.socket.connected);
    const instance = ServerContext.useStoreState(state => state.socket.instance);

    const statsListener = (data: string) => {
        let stats: any = {};
        try {
            stats = JSON.parse(data);
        } catch (e) {
            return;
        }

        setStats({
            memory: stats.memory_bytes,
            cpu: stats.cpu_absolute,
            disk: stats.disk_bytes,
            tx: stats.network.tx_bytes,
            rx: stats.network.rx_bytes,
            uptime: stats.uptime || 0,
        });
    };

    useEffect(() => {
        if (!connected || !instance) {
            return;
        }

        instance.addListener(SocketEvent.STATS, statsListener);
        instance.send(SocketRequest.SEND_STATS);

        return () => {
            instance.removeListener(SocketEvent.STATS, statsListener);
        };
    }, [ instance, connected ]);

    const isInstalling = ServerContext.useStoreState(state => state.server.isInstalling);
    const isTransferring = ServerContext.useStoreState(state => state.server.data!.isTransferring);
    const name = ServerContext.useStoreState(state => state.server.data!.name);
    const serverID = ServerContext.useStoreState(state => state.server.data!.id);
    const node = ServerContext.useStoreState(state => state.server.data!.node);
    const limits = ServerContext.useStoreState((state) => state.server.data!.limits);
    const allocation = ServerContext.useStoreState((state) => {
        const match = state.server.data!.allocations.find((allocation) => allocation.isDefault);

        return !match ? 'n/a' : `${match.alias || ip(match.ip)}:${match.port}`;
    });

    
    const Limits = useMemo(
        () => ({
            cpu: limits?.cpu ? `${limits.cpu}%` : null,
            memory: limits?.memory ? bytesToString(mbToBytes(limits.memory)) : null,
            disk: limits?.disk ? bytesToString(mbToBytes(limits.disk)) : null,
        }),
        [limits]
    );

    useEffect(() => {
        if (!connected || !instance) {
            return;
        }

        instance.send(SocketRequest.SEND_STATS);
    }, [instance, connected]);

    useWebsocketEvent(SocketEvent.STATS, (data) => {
        let stats: any = {};
        try {
            stats = JSON.parse(data);
        } catch (e) {
            return;
        }

        setStats({
            memory: stats.memory_bytes,
            cpu: stats.cpu_absolute,
            disk: stats.disk_bytes,
            tx: stats.network.tx_bytes,
            rx: stats.network.rx_bytes,
            uptime: stats.uptime || 0,
        });
    });

    return (
        <div className={`break-words`}>
            <DetailsItem className='long'>
                <div className='mainCard'>
                    <b className='text-lg'>{name}</b>
                    <div className={'flex align-center gap-x-1 mt-2'}>
                        {status == 'offline' ?
                            <>
                                <span css="color:#AC2427;"><Icon.Radio size={24}/></span>
                                Offline
                            </>
                            :
                            <>
                                {status == 'running' ?
                                    <>
                                    <span css="color:#14914E;"><Icon.Radio size={24}/></span>
                                    Online
                                    </>
                                :
                                <>
                                    {status == 'stopping' ?
                                        <>
                                            <span css="color:#AC2427;"><Icon.Radio size={24}/></span>
                                            Offline
                                        </>
                                    :
                                    <>
                                        <span css="color:orange;"><Icon.Radio size={24}/></span>
                                        Starting
                                    </>
                                    }
                                </>
                                }
                            </>
                        }
                    </div>
                    <div className={'flex align-center gap-x-1 mt-2'}>
                        {stats.uptime > 0 &&
                        <>
                            <span css={'color:var(--primary);'}><Icon.Power size={24}/></span>
                            <UptimeDuration uptime={stats.uptime / 1000}/>
                        </>
                        }
                    </div>
                    <div className={'flex align-center gap-x-1 mt-2'}>
                        <CopyOnClick text={allocation}>
                            <>
                                <span css={'color:var(--primary);'}><Icon.Globe size={24}/></span>
                                {allocation}
                            </>
                        </CopyOnClick>
                    </div>
                    <div className={'flex align-center gap-x-1 mt-2'}>
                        <CopyOnClick text={serverID}>
                            <>
                                <span css={'color:var(--primary);'}><Icon.Hash size={24}/></span>
                                {serverID}
                            </>
                        </CopyOnClick>
                    </div>
                    <div className={'flex align-center gap-x-1 mt-2'}>
                        <span css={'color:var(--primary);'}><Icon.Server size={24}/></span>
                        {node}
                    </div>
                </div>
            </DetailsItem>
            <DetailsItem className={`w-full`}>
                <div className='discription'>
                    <p>{bytesToString(stats.memory)}</p>
                    <span>/ {Limits.memory || <>&infin;</>} ram</span>
                </div>
                <RamGraph/>
            </DetailsItem>
            <DetailsItem className={`w-full`}>
                <div className='discription'>
                    <p>{stats.cpu.toFixed(2)}%</p>
                    <span>/ {Limits.cpu || <>&infin;</>} CPU</span>
                </div>
                <CPUGraph/>
            </DetailsItem>
            <DetailsItem className={`w-full`}>
                <div className='discription'>
                    <p>{bytesToString(stats.disk)}</p>
                    <span>/ {Limits.disk || <>&infin;</>} disk</span>
                </div>
                <DISKGraph/>
            </DetailsItem>
        </div>
    );
};

export default SideGraph;
