<?php

class Iati_Organisation_Element_AnnualPlanningBudget_PeriodEnd extends Iati_Organisation_Element_BaseElement
{
    protected $isRequired = true;
    protected $parent = 'AnnualPlanningBudget';
    protected $className = 'PeriodEnd';
    protected $displayName = 'Period End';
    protected $iatiAttribs = array('date' , 'text');
    protected $tableName = 'organisation/annual_planning_budget/period_end';
   
    public function __construct()
    {
        self::$count++;
    }
}