import React, { memo, useState, useEffect } from 'react';
import { ServerContext } from '@/state/server';
import ContentContainer from '@/components/elements/ContentContainer';
import tw from 'twin.macro';
import ServerContentBlock from '@/components/elements/ServerContentBlock';
import isEqual from 'react-fast-compare';
import Spinner from '@/components/elements/Spinner';
import Features from '@feature/Features';
import Console from '@/components/server/console/Console';
import StatGraphs from '@/components/server/console/StatGraphs';
import ServerDetailsBlock from '@/components/server/console/ServerDetailsBlock';
import TopElement from '@/components/server/console/TopElement';
import SideGraph from '@/components/server/console/SideGraph';
import { Alert } from '@/components/elements/alert';
import styled  from 'styled-components/macro'; 
import { Server_is_transferred, Server_is_installing, Node_is_maintenance } from '@/lang';

const SideGraphDiv = styled.div`
    ${tw`w-full lg:pr-4`}
    display:var(--sidegraph);
    
    @media (min-width: 1024px){
        max-width:25%;
    }
`;

export type PowerAction = 'start' | 'stop' | 'restart' | 'kill';

const ServerConsoleContainer = () => {
    const name = ServerContext.useStoreState((state) => state.server.data!.name);
    const description = ServerContext.useStoreState((state) => state.server.data!.description);
    const isInstalling = ServerContext.useStoreState((state) => state.server.isInstalling);
    const isTransferring = ServerContext.useStoreState((state) => state.server.data!.isTransferring);
    const eggFeatures = ServerContext.useStoreState((state) => state.server.data!.eggFeatures, isEqual);
    const isNodeUnderMaintenance = ServerContext.useStoreState((state) => state.server.data!.isNodeUnderMaintenance);

    return (
        <ServerContentBlock title={'Console'}>
            <div css='display:var(--infoelement) !important;'>
                <TopElement/>   
            </div>
            <div css='display:var(--graphcard) !important;'>
                <ServerDetailsBlock/>
            </div>
            <div className={'flex flex-wrap lg:flex-nowrap'}>
                <SideGraphDiv>
                    <SideGraph/>
                </SideGraphDiv>
                <div className={'w-full mt-4 lg:mt-0'}>
                    <Spinner.Suspense>
                        <Console />
                    </Spinner.Suspense>
                    {(isNodeUnderMaintenance || isInstalling || isTransferring) && (
                        <Alert type={'warning'} className='mt-3'>
                            {isNodeUnderMaintenance
                                ? `${Node_is_maintenance}`
                                : isInstalling
                                ? `${Server_is_installing}`
                                : `${Server_is_transferred}`}
                        </Alert>
                    )}
                    <div className={'grid grid-cols-1 md:grid-cols-3 gap-2 sm:gap-4'}>
                        <StatGraphs />
                    </div>
                </div>
            </div>
            <Features enabled={eggFeatures} />
        </ServerContentBlock>
    );
};

export default memo(ServerConsoleContainer, isEqual);
