import { THEME_NAME } from '../../helpers';
import { __ } from '@wordpress/i18n';
import {
  InnerBlocks,
  RichText,
  InspectorControls,
  useBlockProps,
  useInnerBlocksProps,
  withColors,
  withFontSizes,
  PanelColorSettings,
} from '@wordpress/block-editor';
import { PanelBody, Button, TextControl, __experimentalDivider as Divider, } from '@wordpress/components';
import { Fragment, useEffect, RawHTML, useState } from '@wordpress/element';
import { useSelect, useDispatch} from '@wordpress/data';
import { compose } from '@wordpress/compose';
import {createBlock} from '@wordpress/blocks';
import classnames from 'classnames';
import memoize from 'memize';
import { times } from 'lodash';

export function TabEdit( props ) {
  const {
    clientId,
    attributes,
    setAttributes,
    className,
    backgroundColor,
    setBackgroundColor,
    textColor,
    setTextColor,
    borderColor,
    setBorderColor,
    fontSize,
  } = props;

  const {
    title,
    tabLabelsArray,
    needUpdate,
    customBackgroundColor,
    customTextColor,
    customBorderColor
  } = attributes;

  // タブの数だけコンテンツブロックを生成
  const getItemsTemplate = memoize( ( items ) => {
    return times( items, () => [ 'core/paragraph', {placeholder: "Tab Content"} ] );
  } );

  // useEffectで扱う変数・関数
  const [sourceIdx, setSourceIdx] = useState(-1);
  const [targetIdx, setTargetIdx] = useState(-1);
  const [removeIdx, setRemoveIdx] = useState(-1);
  const [addIdx, setAddIdx] = useState(-1);
  const { replaceInnerBlocks } = useDispatch('core/block-editor');

  // InnerBlocksを取得
  function getInnerBlocks(clientId) {
    return wp.data.select('core/block-editor').getBlocks(clientId);
  }

  useEffect(() => {
    //console.log("sourceIdx " + sourceIdx);
    //console.log("targetIdx " + targetIdx);
    //console.log("removeIdx " + removeIdx);
    //console.log("addIdx " + addIdx);

    // 入れ替え処理
    if (sourceIdx != -1 && targetIdx != -1) {
      // InnerBlocksを取得
      const innerBlocks = getInnerBlocks(clientId);
      //console.log(innerBlocks);

      // ソースブロックの情報を退避
      const sourceBlock = innerBlocks[sourceIdx];
      const sourceAttributes = sourceBlock.attributes;
      const sourceContent = sourceBlock.content;

      // ターゲットブロックの退避
      const targetBlock = innerBlocks[targetIdx];
      const targetAttributes = targetBlock.attributes;
      const targetContent = targetBlock.content;

      // ターゲット→ソース
      innerBlocks[sourceIdx] = targetBlock;
      innerBlocks[sourceIdx].atrributes = targetAttributes;
      innerBlocks[sourceIdx].content = targetContent;

      // ソース→ターゲット
      innerBlocks[targetIdx] = sourceBlock;
      innerBlocks[targetIdx].attributes = sourceAttributes;
      innerBlocks[targetIdx].content = sourceContent;

      // 再レンダリング
      replaceInnerBlocks(clientId, innerBlocks, false);

      // indexをリセット
      setSourceIdx(-1);
      setTargetIdx(-1);
    }

    // 削除処理
    if (removeIdx != -1) {
      // InnerBlocksを取得
      const innerBlocks = getInnerBlocks(clientId);

      // 指定したブロックを削除
      innerBlocks.splice(removeIdx, 1);

      // 再レンダリング
      replaceInnerBlocks(clientId, innerBlocks, false);

      // indexをリセット
      setRemoveIdx(-1);
    }

    // 追加処理
    if (addIdx != -1) {
      // InnerBlocksを取得
      const innerBlocks = getInnerBlocks(clientId);

      // 新規ブロックを生成
      const newBlock = createBlock('core/paragraph', {placeholder: "Tab Content"});
      innerBlocks.push(newBlock);

      // 再レンダリング
      replaceInnerBlocks(clientId, innerBlocks, false);

      // indexをリセット
      setAddIdx(-1);
    }

  },[clientId, sourceIdx, targetIdx, removeIdx, addIdx]);

  // タブラベルの配列を入れ替える
  function replaceArrayElements(array, targetIdx, sourceIdx) {
    var newArray = array.concat();

    var val = newArray[sourceIdx];
    newArray.splice(sourceIdx, 1, newArray[targetIdx]);
    newArray.splice(targetIdx, 1, val);

    return newArray;
  }

  // タブ追加処理
  function addTab() {
    //console.log("addTab");
    var tabLabels = [];

    tabLabels = tabLabelsArray.concat("tab label");

    setAddIdx(1);
    setAttributes({tabLabelsArray: tabLabels});
  }

  // タブラベル変更処理
  function changeTabLabel(index, value) {
    var tabLabels = tabLabelsArray.concat();
    //console.log(tabLabels);

    tabLabels[index] = value;
    setAttributes({tabLabelsArray: tabLabels});
  }

  // タブ削除処理
  function deleteTab (index) {
    var tabLabels = tabLabelsArray.concat();
    //console.log(tabLabels);

    if (tabLabels.length <= 1) {
      return;
    }
    //console.log('deleteTab: ' + index)

    tabLabels.splice(index, 1);
    //console.log(tabLabels);

    setRemoveIdx(index);
    setAttributes({tabLabelsArray: tabLabels});
  }

  // 指定したタブをひとつ上に移動する処理
  function moveTabUp (index) {
    var tabLabels = tabLabelsArray.concat();

    // タブがひとつしかない場合は実行しない
    if (tabLabels.count === 1) {
      return;
    }
    // 指定したタブが一番上の場合は実行しない
    if (index === 0) {
      return;
    }

    // タブラベル入れ替え
    tabLabels = replaceArrayElements(tabLabels, index - 1, index);
    // タブコンテンツ入れ替え
    setTargetIdx(index - 1);
    setSourceIdx(index);

    setAttributes({tabLabelsArray: tabLabels});
  }

  // 指定したタブをひとつ下に移動する処理
  function moveTabDown (index) {
    var tabLabels = tabLabelsArray.concat();

    // タブがひとつしかない場合は実行しない
    if (tabLabels.count === 1) {
      return;
    }
    // 指定したタブが一番下の場合は実行しない
    if (index + 1 === tabLabels.length) {
      return;
    }

    // タブラベル入れ替え
    tabLabels = replaceArrayElements(tabLabels, index + 1, index);
    // タブコンテンツ入れ替え
    setTargetIdx(index + 1);
    setSourceIdx(index);
  
    setAttributes({tabLabelsArray: tabLabels});
  }

  useEffect( () => {
    setAttributes( { backgroundColorValue: backgroundColor.color } );
    setAttributes( { textColorValue: textColor.color } );
    setAttributes( { borderColorValue: borderColor.color } );
  }, [ backgroundColor, textColor, borderColor ] );

  const classes = classnames( className, {
    'tab-block': true,
    'block-box': true,
    'cocoon-block-tab': true,
    'has-text-color': textColor.color,
    'has-background': backgroundColor.color,
    'has-border-color': borderColor.color,
    [ backgroundColor.class ]: backgroundColor.class,
    [ textColor.class ]: textColor.class,
    [ borderColor.class ]: borderColor.class,
    [ fontSize.class ]: fontSize.class,
  });

  const styles = {
    '--cocoon-custom-border-color': customBorderColor || undefined,
    '--cocoon-custom-background-color': customBackgroundColor || undefined,
    '--cocoon-custom-text-color': customTextColor || undefined,
  };
 
  const blockProps = useBlockProps( {
    className: classes,
    style: styles,
  });

  return (
    <Fragment>
      <InspectorControls>
        <PanelBody title={__('タブ設定', THEME_NAME)}>
          {tabLabelsArray.map((label, index) => {
            return (
              <div className={"tab-setting tab-setting-" + index}>
                <TextControl label={"tab " + (index + 1)} value={label} onChange={ (value) => changeTabLabel(index, value)}/>
                <Button disabled={tabLabelsArray.length > 1 ? false : true} onClick={() => {deleteTab(index)}}>{__('タブ削除', THEME_NAME)}</Button>
                <Button disabled={index === 0 ? true : false} onClick={() => moveTabUp(index)}>{__('上に移動', THEME_NAME)}</Button>
                <Button disabled={(index + 1) === tabLabelsArray.length ? true : false} onClick={() => {moveTabDown(index)}}>{__('下に移動', THEME_NAME)}</Button>
                <Divider />
              </div>
            );
          })}
          <Button onClick={() => {addTab()}}>{__('タブ追加', THEME_NAME)}</Button>
        </PanelBody>
        <PanelBody title={ __( 'スタイル設定', THEME_NAME ) }>
          <PanelColorSettings
            title={ __( '色設定', THEME_NAME ) }
            colorSettings={ [
              {
                label: __( '背景色', THEME_NAME ),
                onChange: setBackgroundColor,
                value: backgroundColor.color,
              },
              {
                label: __( '文字色', THEME_NAME ),
                onChange: setTextColor,
                value: textColor.color,
              },
              {
                label: __( 'ボーダー色', THEME_NAME ),
                onChange: setBorderColor,
                value: borderColor.color,
              },
            ] }
            __experimentalIsRenderedInSidebar={ true }
          />
        </PanelBody>
      </InspectorControls>

      <div { ...blockProps }>
        <div className="tab-title">
          <RichText
            value={title}
            onChange={ (value) => setAttributes( {title: value})}
            placeholder={__('タイトル', THEME_NAME)}
          />
        </div>
        <ul className="tab-label-group">
          {tabLabelsArray.map((label, index) => {
            return (<li class={"tab-label " + "tab-label-" + index}><RawHTML>{label}</RawHTML></li>);
          })}
          {/* <li class={"tab-label tab-add-button"}>+</li> */}
          <Button className="tab-add-button" onClick={() => {addTab()}}>+</Button>
        </ul>
        <div className="tab-content-group">
          <InnerBlocks
            template={getItemsTemplate(tabLabelsArray.length)}
            templateLock="false"
          />
        </div>
      </div>
    </Fragment>
  );
}

export default compose( [
  withColors( 'backgroundColor', {
    textColor: 'color',
    borderColor: 'border-color',
  } ),
  withFontSizes( 'fontSize' ),
] )( TabEdit );
