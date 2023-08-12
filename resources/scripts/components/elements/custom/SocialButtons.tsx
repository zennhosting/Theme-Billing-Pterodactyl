import React from 'react';
import Website from '@/components/elements/custom/social/Website';
import Discord from '@/components/elements/custom/social/Discord';
import Billing from '@/components/elements/custom/social/Billing';
import Status from '@/components/elements/custom/social/Status';
import Knowledgebase from '@/components/elements/custom/social/Knowledgebase';

export default () => {

    return (
        <>
            <Website/>
            <Discord/>
            <Billing/>
            <Status/>
            <Knowledgebase/>
        </>
    );
};
